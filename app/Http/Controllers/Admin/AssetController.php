<?php
// app/Http/Controllers/Admin/AssetController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\AssetAssignment;
use App\Models\ActivityLog;
use App\Services\AssetTagService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function __construct(private AssetTagService $tagService) {}

    public function index(Request $request): View
    {
        $user = auth()->user();
        $canSelectDepartment =  !$user->department_id ||   $user->role?->name === 'super_admin';
        $assets = Asset::with(['category', 'vendor', 'assignedDepartment', 'assignedEmployee'])
            ->when($request->status,      fn($q) => $q->where('status', $request->status))
            ->when($request->condition,   fn($q) => $q->where('condition', $request->condition))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->department_id, fn($q) => $q->where('assigned_department_id', $request->department_id))
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('asset_tag', 'like', "%{$request->search}%")
                       ->orWhere('name', 'like', "%{$request->search}%")
                       ->orWhere('serial_no', 'like', "%{$request->search}%")
                       ->orWhere('make_brand', 'like', "%{$request->search}%");
                });
            })
            ->latest()->paginate(25)->withQueryString();

        $categories  = AssetCategory::active()->get();
        $departments = Department::active()->get();

        $statusCounts = Asset::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        return view('admin.assets.index', compact(
            'assets', 'categories', 'departments', 'statusCounts', 'canSelectDepartment'
        ));
    }

    public function create(): View
    {

        $user = auth()->user();
        $canSelectDepartment =  !$user->department_id ||   $user->role?->name === 'super_admin';
        $user = auth()->user();

        $canChooseDepartment =
            !$user->department_id ||
            $user->role?->name === 'super_admin';



        $categories  = AssetCategory::active()->get();
        $vendors     = Vendor::active()->get();
        $departments = Department::active()->get();
        $employees   = \App\Models\User::active()->where('status', 'active')->get();

        return view('admin.assets.create', compact(
            'categories', 'vendors', 'departments', 'employees',
            'canChooseDepartment','canSelectDepartment'
        ));
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:200'],
            'asset_type'          => ['nullable', 'string', 'max:50'],
            'category_id'         => ['required', 'exists:asset_categories,id'],
            'sub_category_id'     => ['nullable', 'string'],
            'sub_category_name'   => ['nullable', 'string', 'max:100'],
            'make_brand'          => ['nullable', 'string', 'max:100'],
            'model'               => ['nullable', 'string', 'max:100'],
            'serial_no'           => ['nullable', 'string', 'max:100', 'unique:assets,serial_no'],
            'description'         => ['nullable', 'string'],
            'purchase_date'       => ['nullable', 'date'],
            'purchase_price'      => ['nullable', 'numeric', 'min:0'],
            'warranty_expiry_date'=> ['nullable', 'date'],
            'under_amc'           => ['boolean'],
            'amc_start_date'      => ['nullable', 'date'],
            'amc_end_date'        => ['nullable', 'date'],
            'amc_reference_no'    => ['nullable', 'string', 'max:100'],
            'vendor_id'           => ['nullable', 'exists:vendors,id'],
            'invoice_no'          => ['nullable', 'string', 'max:100'],
            'depreciation_rate'   => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status'              => ['required', 'in:available,in_use,under_maintenance,disposed,lost,transferred'],
            'condition'           => ['required', 'in:new,good,fair,poor,condemned'],
            'assigned_employee_id'   => ['nullable', 'exists:users,id'],
            'location_building'   => ['nullable', 'string', 'max:100'],
            'location_block'      => ['nullable', 'string', 'max:50'],
            'location_floor'      => ['nullable', 'string', 'max:20'],
            'location_room_no'    => ['nullable', 'string', 'max:30'],
            'assigned_on'         => ['nullable', 'date'],
            'assignment_notes'    => ['nullable', 'string'],
        ]);

        // Generate Asset Tag
        $validated['asset_tag']   = $this->tagService->generate($validated['category_id']);
        $validated['under_amc']   = $request->boolean('under_amc');
        $validated['created_by']  = auth()->id();

        // Auto-fill depreciation from category if not set
        if (empty($validated['depreciation_rate'])) {
            $category = AssetCategory::find($validated['category_id']);
            $validated['depreciation_rate'] = $category?->depreciation_rate;
        }

        // Handle invoice file upload
        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')
                ->store('invoices', 'public');
        }

         $user = auth()->user();
        if (
            $user->department_id &&
            $user->role?->name !== 'super_admin'
        ) {
            $validated['assigned_department_id'] = $user->department_id;
            $validated['assigned_to_type'] = 'department';

        }

        $validated['home_department_id']= $validated['assigned_department_id'];

        $asset = Asset::create($validated);
        if ($asset->assigned_department_id) {

            AssetAssignment::create([
                'asset_id'              => $asset->id,
                'transaction_type'      => 'initial',
                'to_type'               => 'department',
                'to_department_id'      => $asset->assigned_department_id,
                'transaction_date'      => now(),
                'form_no'               => AssetAssignment::generateFormNo('initial'),
                'remarks'               => 'Initial asset registration',
                'created_by'            => auth()->id(),
            ]);
        }
        // Calculate current value
        $asset->update(['current_value' => $asset->calculateCurrentValue()]);

        ActivityLog::log('created', 'assets', $asset);

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', "Asset '{$asset->asset_tag}' created successfully.");
    }

    public function show(Asset $asset): View
    {
        $departments = Department::active()->get();
        $employees   = \App\Models\User::active()->where('status', 'active')->get();

        $asset->load([
            'category', 'vendor',
            'assignedDepartment', 'assignedEmployee.designation',
            'assignments.fromDepartment', 'assignments.fromEmployee',
            'assignments.toDepartment',   'assignments.toEmployee',
            'maintenances.vendor',
            'documents',
            'createdBy', 'updatedBy',
        ]);

        return view('admin.assets.show', compact('asset', 'departments', 'employees'));
    }

    public function edit(Asset $asset): View
    {
         $this->authorize('edit', $asset);
        $user = auth()->user();
        $canSelectDepartment =  !$user->department_id ||   $user->role?->name === 'super_admin';
        $categories  = AssetCategory::active()->get();
        $vendors     = Vendor::active()->get();
        $departments = Department::active()->get();
        $employees   = \App\Models\User::active()->get();
        $subCategories = $asset->category?->active_sub_categories ?? [];

        return view('admin.assets.edit', compact(
            'asset', 'categories', 'vendors', 'departments', 'employees', 'subCategories','canSelectDepartment'
        ));
    }

    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $this->authorize('edit', $asset);
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:200'],
            'asset_type'          => ['nullable', 'string', 'max:50'],
            'category_id'         => ['required', 'exists:asset_categories,id'],
            'sub_category_id'     => ['nullable', 'string'],
            'sub_category_name'   => ['nullable', 'string', 'max:100'],
            'make_brand'          => ['nullable', 'string', 'max:100'],
            'model'               => ['nullable', 'string', 'max:100'],
            'serial_no'           => ['nullable', 'string', 'max:100', 'unique:assets,serial_no,' . $asset->id],
            'description'         => ['nullable', 'string'],
            'purchase_date'       => ['nullable', 'date'],
            'purchase_price'      => ['nullable', 'numeric', 'min:0'],
            'warranty_expiry_date'=> ['nullable', 'date'],
            'under_amc'           => ['boolean'],
            'amc_start_date'      => ['nullable', 'date'],
            'amc_end_date'        => ['nullable', 'date'],
            'amc_reference_no'    => ['nullable', 'string'],
            'vendor_id'           => ['nullable', 'exists:vendors,id'],
            'invoice_no'          => ['nullable', 'string', 'max:100'],
            'depreciation_rate'   => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status'              => ['required'],
            'condition'           => ['required'],
            'assigned_to_type'    => ['nullable', 'in:department,employee'],
            'assigned_department_id' => ['nullable', 'exists:departments,id'],
            'assigned_employee_id'   => ['nullable', 'exists:users,id'],
            'location_building'   => ['nullable', 'string'],
            'location_block'      => ['nullable', 'string'],
            'location_floor'      => ['nullable', 'string'],
            'location_room_no'    => ['nullable', 'string'],
            'assigned_on'         => ['nullable', 'date'],
        ]);
        $user = auth()->user();
        if ($user->role?->name === 'super_admin')
        {
            $validated['home_department_id']= $validated['assigned_department_id'];
        }
        $validated['under_amc']   = $request->boolean('under_amc');
        $validated['updated_by']  = auth()->id();

        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')
                ->store('invoices', 'public');
        }
        $old = $asset->toArray();
        $asset->update($validated);
        $asset->update(['current_value' => $asset->calculateCurrentValue()]);

        ActivityLog::log('updated', 'assets', $asset, $old, $asset->toArray());

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {

        if ($asset->status === 'in_use') {
            return back()->with('error', 'Cannot delete an asset that is currently in use.');
        }

        ActivityLog::log('deleted', 'assets', $asset);
        $asset->delete();

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset deleted successfully.');
    }

    public function generateTag(Request $request): JsonResponse
    {
        $request->validate(['category_id' => 'required|exists:asset_categories,id']);
        $tag = $this->tagService->generate($request->category_id);
        return response()->json(['tag' => $tag]);
    }

    public function generateQr(Asset $asset)
    {
        // QR Code generation placeholder
        return response()->json(['url' => route('admin.assets.show', $asset)]);
    }

    public function printLabel(Asset $asset): View
    {
        return view('admin.assets.print-label', compact('asset'));
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $assets = Asset::with('category')
            ->when($request->search, fn($q) => $q->where(function ($q2) use ($request) {
                $q2->where('asset_tag', 'like', "%{$request->search}%")
                   ->orWhere('name', 'like', "%{$request->search}%");
            }))
            ->select('id', 'asset_tag', 'name', 'status', 'category_id')
            ->limit(50)->get()
            ->map(fn($a) => ['id' => $a->id, 'text' => "{$a->asset_tag} - {$a->name}"]);

        return response()->json(['data' => $assets]);
    }
}
