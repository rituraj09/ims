<?php
// app/Http/Controllers/Admin/AssetAssignmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Department;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetAssignmentController extends Controller
{
   public function index(Request $request): View
    {
        $assignments = AssetAssignment::with([
                'asset',
                'toDepartment',
                'toEmployee',
                'fromDepartment',
                'fromEmployee',
                'authorizedBy'
            ])
            ->when($request->type, fn($q) =>
                $q->where('transaction_type', $request->type)
            )
            ->when($request->date_from, fn($q) =>
                $q->whereDate('transaction_date', '>=', $request->date_from)
            )
            ->when($request->date_to, fn($q) =>
                $q->whereDate('transaction_date', '<=', $request->date_to)
            )
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('form_no', 'like', "%{$search}%")
                        ->orWhereHas('asset', function ($asset) use ($search) {
                            $asset->where('asset_tag', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%"); // asset name field
                        });
                });
            })
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('admin.assignments.index', compact('assignments'));
    }

    public function create(Asset $asset): View
    {
        $departments = Department::active()->get();
        $employees   = User::active()->get();

        return view('admin.assignments.create',
            compact('asset', 'departments', 'employees'));
    }

    public function store(Request $request, Asset $asset): RedirectResponse
    {
        $validated = $request->validate([
            'transaction_type'    => ['required', 'in:handover,transfer,maintenance'],
            'to_type'             => ['required', 'in:department,employee'],
            'to_department_id'    => ['required_if:to_type,department', 'nullable', 'exists:departments,id'],
            'to_employee_id'      => ['required_if:to_type,employee', 'nullable', 'exists:users,id'],
            'to_location_building'=> ['nullable', 'string'],
            'to_location_floor'   => ['nullable', 'string'],
            'to_location_room_no' => ['nullable', 'string'],
            'condition_at_handover' => ['required', 'in:new,good,fair,poor,condemned'],
            'transaction_date'    => ['required', 'date'],
            'authorized_by'       => ['nullable', 'exists:users,id'],
            'remarks'             => ['nullable', 'string'],
        ]);

        // Set from details
        $validated['from_type']          = $asset->assigned_to_type;
        $validated['from_department_id'] = $asset->assigned_department_id;
        $validated['from_employee_id']   = $asset->assigned_employee_id;
        $validated['from_location_building'] = $asset->location_building;
        $validated['from_location_floor']    = $asset->location_floor;
        $validated['from_location_room_no']  = $asset->location_room_no;
        $validated['form_no']            = AssetAssignment::generateFormNo($validated['transaction_type']);
        $validated['asset_id']           = $asset->id;
        $validated['created_by']         = auth()->id();

        $assignment = AssetAssignment::create($validated);

        // Update asset location
        $asset->update([
            'status'                 => 'in_use',
            'assigned_to_type'       => $validated['to_type'],
            'assigned_department_id' => $validated['to_department_id'] ?? null,
            'assigned_employee_id'   => $validated['to_employee_id'] ?? null,
            'location_building'      => $validated['to_location_building'] ?? null,
            'location_floor'         => $validated['to_location_floor'] ?? null,
            'location_room_no'       => $validated['to_location_room_no'] ?? null,
            'assigned_on'            => $validated['transaction_date'],
        ]);

        ActivityLog::log('assigned', 'assets', $asset,
            description: "Handover form: {$assignment->form_no}");

        return redirect()->route('admin.assignments.show', $assignment)
            ->with('success', "Asset assigned. Form No: {$assignment->form_no}");
    }

    public function show(AssetAssignment $assignment): View
    {
        // Using integer ID since route uses {id}
        $assignment = AssetAssignment::with([
            'asset.category',
            'toDepartment', 'toEmployee.designation',
            'fromDepartment', 'fromEmployee',
            'authorizedBy', 'documents',
        ])->findOrFail($assignment->id ?? request()->route('id'));

        return view('admin.assignments.show', compact('assignment'));
    }

    public function takeover(Request $request, Asset $asset): RedirectResponse
    {
        $validated = $request->validate([
            'condition_at_return' => ['required', 'in:new,good,fair,poor,condemned'],
            'transaction_date'    => ['required', 'date'],
            'remarks'             => ['nullable', 'string'],
        ]);

        $assignment = AssetAssignment::create([
            'asset_id'            => $asset->id,
            'transaction_type'    => 'takeover',
            'from_type'           => $asset->assigned_to_type,
            'from_department_id'  => $asset->assigned_department_id,
            'from_employee_id'    => $asset->assigned_employee_id,
            'to_type'             => 'store',
            'condition_at_return' => $validated['condition_at_return'],
            'transaction_date'    => $validated['transaction_date'],
            'form_no'             => AssetAssignment::generateFormNo('takeover'),
            'remarks'             => $validated['remarks'],
            'created_by'          => auth()->id(),
        ]);

        $asset->update([
            'status'                 => 'available',
            'assigned_to_type'       => null,
            'assigned_department_id' => null,
            'assigned_employee_id'   => null,
            'location_building'      => null,
            'location_floor'         => null,
            'location_room_no'       => null,
            'assigned_on'            => null,
        ]);

        ActivityLog::log('takeover', 'assets', $asset);

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', "Asset taken back. Form: {$assignment->form_no}");
    }

    public function transfer(Request $request, Asset $asset): RedirectResponse
    {
        $validated = $request->validate([
            'to_type'             => ['required', 'in:department,employee'],
            'to_department_id'    => ['required_if:to_type,department', 'nullable'],
            'to_employee_id'      => ['required_if:to_type,employee', 'nullable'],
            'to_location_building'=> ['nullable', 'string'],
            'to_location_floor'   => ['nullable', 'string'],
            'to_location_room_no' => ['nullable', 'string'],
            'transaction_date'    => ['required', 'date'],
            'remarks'             => ['nullable', 'string'],
        ]);

        $assignment = AssetAssignment::create([
            'asset_id'               => $asset->id,
            'transaction_type'       => 'transfer',
            'from_type'              => $asset->assigned_to_type,
            'from_department_id'     => $asset->assigned_department_id,
            'from_employee_id'       => $asset->assigned_employee_id,
            'to_type'                => $validated['to_type'],
            'to_department_id'       => $validated['to_department_id'] ?? null,
            'to_employee_id'         => $validated['to_employee_id'] ?? null,
            'to_location_building'   => $validated['to_location_building'] ?? null,
            'to_location_floor'      => $validated['to_location_floor'] ?? null,
            'to_location_room_no'    => $validated['to_location_room_no'] ?? null,
            'transaction_date'       => $validated['transaction_date'],
            'form_no'                => AssetAssignment::generateFormNo('transfer'),
            'remarks'                => $validated['remarks'] ?? null,
            'created_by'             => auth()->id(),
        ]);

        $asset->update([
            'assigned_to_type'       => $validated['to_type'],
            'assigned_department_id' => $validated['to_department_id'] ?? null,
            'assigned_employee_id'   => $validated['to_employee_id'] ?? null,
            'location_building'      => $validated['to_location_building'] ?? null,
            'location_floor'         => $validated['to_location_floor'] ?? null,
            'location_room_no'       => $validated['to_location_room_no'] ?? null,
            'assigned_on'            => $validated['transaction_date'],
        ]);

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', "Asset transferred. Form: {$assignment->form_no}");
    }

    public function printForm(int $id): View
    {
        $assignment = AssetAssignment::with([
            'asset.category', 'toDepartment',
            'toEmployee.designation', 'fromDepartment',
            'fromEmployee', 'authorizedBy',
        ])->findOrFail($id);

        return view('admin.assignments.print', compact('assignment'));
    }

    public function uploadForm(Request $request, int $id): RedirectResponse
    {
        $request->validate(['form_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120']]);

        $assignment = AssetAssignment::findOrFail($id);
        $path = $request->file('form_file')->store('handover-forms', 'public');
        $assignment->update(['handover_form_path' => $path]);

        return back()->with('success', 'Form uploaded successfully.');
    }
}
