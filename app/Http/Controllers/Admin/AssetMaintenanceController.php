<?php
// app/Http/Controllers/Admin/AssetMaintenanceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Vendor;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssetMaintenanceController extends Controller
{
    public function index(Request $request): View
    {
        $maintenances = AssetMaintenance::with(['asset.category', 'vendor'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type,   fn($q) => $q->where('maintenance_type', $request->type))
            ->when($request->search, fn($q) => $q->whereHas('asset', fn($a) =>
                $a->where('asset_tag', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%")))
            ->latest('start_date')->paginate(25)->withQueryString();

        $statusCounts = AssetMaintenance::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        return view('admin.maintenances.index', compact('maintenances', 'statusCounts'));
    }

    public function create(Request $request): View
    {
        $assets  = Asset::with('category')->latest()->get();
        $vendors = Vendor::active()->get();

        $selectedAsset = $request->asset_id
            ? Asset::find($request->asset_id)
            : null;

        return view('admin.maintenances.create',
            compact('assets', 'vendors', 'selectedAsset'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asset_id'          => ['required', 'exists:assets,id'],
            'maintenance_type'  => ['required', 'in:preventive,corrective,amc,calibration,inspection,other'],
            'reference_no'      => ['nullable', 'string', 'max:50'],
            'scheduled_date'    => ['nullable', 'date'],
            'start_date'        => ['required', 'date'],
            'completion_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
            'vendor_id'         => ['nullable', 'exists:vendors,id'],
            'technician_name'   => ['nullable', 'string', 'max:100'],
            'technician_contact'=> ['nullable', 'string', 'max:20'],
            'issue_description' => ['nullable', 'string'],
            'work_done'         => ['nullable', 'string'],
            'parts_replaced'    => ['nullable', 'string'],
            'maintenance_cost'  => ['nullable', 'numeric', 'min:0'],
            'invoice_no'        => ['nullable', 'string', 'max:100'],
            'status'            => ['required', 'in:scheduled,in_progress,completed,cancelled'],
            'condition_after'   => ['nullable', 'in:new,good,fair,poor,condemned'],
            'remarks'           => ['nullable', 'string'],
        ]);

        $validated['created_by'] = auth()->id();

        // Handle invoice file
        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')
                ->store('maintenance-invoices', 'public');
        }

        $maintenance = AssetMaintenance::create($validated);

        // Update asset status if in progress
        if (in_array($validated['status'], ['scheduled', 'in_progress'])) {
            Asset::find($validated['asset_id'])->update([
                'status' => 'under_maintenance'
            ]);
        }

        // If completed, update asset condition
        if ($validated['status'] === 'completed' && !empty($validated['condition_after'])) {
            Asset::find($validated['asset_id'])->update([
                'status'    => 'available',
                'condition' => $validated['condition_after'],
            ]);
        }

        ActivityLog::log('created', 'maintenance', $maintenance);

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance record created successfully.');
    }

    public function show(AssetMaintenance $maintenance): View
    {
        $maintenance->load(['asset.category', 'vendor', 'createdBy', 'updatedBy']);

        return view('admin.maintenances.show', compact('maintenance'));
    }

    public function edit(AssetMaintenance $maintenance): View
    {
        $assets  = Asset::with('category')->latest()->get();
        $vendors = Vendor::active()->get();

        return view('admin.maintenances.edit', compact('maintenance', 'assets', 'vendors'));
    }

    public function update(Request $request, AssetMaintenance $maintenance): RedirectResponse
    {
        $validated = $request->validate([
            'maintenance_type'  => ['required'],
            'start_date'        => ['required', 'date'],
            'completion_date'   => ['nullable', 'date'],
            'vendor_id'         => ['nullable', 'exists:vendors,id'],
            'technician_name'   => ['nullable', 'string', 'max:100'],
            'issue_description' => ['nullable', 'string'],
            'work_done'         => ['nullable', 'string'],
            'maintenance_cost'  => ['nullable', 'numeric', 'min:0'],
            'status'            => ['required'],
            'condition_after'   => ['nullable'],
            'remarks'           => ['nullable', 'string'],
        ]);

        $validated['updated_by'] = auth()->id();
        $maintenance->update($validated);

        // Update asset based on status change
        if ($validated['status'] === 'completed') {
            $maintenance->asset->update([
                'status'    => 'available',
                'condition' => $validated['condition_after'] ?? $maintenance->asset->condition,
            ]);
        }

        ActivityLog::log('updated', 'maintenance', $maintenance);

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance record updated.');
    }

    public function destroy(AssetMaintenance $maintenance): RedirectResponse
    {
        ActivityLog::log('deleted', 'maintenance', $maintenance);
        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance record deleted.');
    }
}
