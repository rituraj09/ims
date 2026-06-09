<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\IpAddress;
use App\Models\IpAllocation;
use App\Models\Asset;
use App\Models\User;
use App\Models\AssetNetworkDetail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class IpAllocationController extends Controller
{
    // ─── Employee-wise allocation list ────────────────────────────────────────

    public function index(Request $request): View
    {
        $role=auth()->user()->role?->name ;
        $query = IpAllocation::with(['ipAddress',
                                'user',
                                'allocatedBy',
                                'asset.networkDetail'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('ipAddress', fn($i) => $i->where('ip_address', 'like', "%{$request->search}%"));
            })
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->date_from, fn($q) => $q->whereDate('date_allocated', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('date_allocated', '<=', $request->date_to));

        $allocations = $query->latest()->paginate(20)->withQueryString();
        $users        = User::orderBy('name')->get(['id', 'name']);
        $availableIps = IpAddress::where('status', 'available')->orderBy('ip_address')->get(['id', 'ip_address', 'subnet_mask', 'gateway', 'dns_primary']);

        return view('admin.ip-allocation.index', compact('allocations', 'users', 'availableIps' ,'role'));
    }

    public function userAssets($id)
    {
        $user = User::findOrFail($id);

        $assets = $user->assignedAssetsIT()
            ->with('networkDetail')
            ->get();

        return response()->json($assets);
    }
    // ─── Assign IP to user ────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ip_address_id' => 'required|exists:ip_addresses,id',
            'user_id'       => 'required|exists:users,id',
            'date_allocated'=> 'required|date',
            'notes'         => 'nullable|string|max:500',
            'asset_id' => 'nullable|exists:assets,id',


            'asset_id' => 'nullable|exists:assets,id',
            'ethernet_mac'  => ['nullable', 'regex:/^([0-9A-Fa-f]{2}[:\-]){5}[0-9A-Fa-f]{2}$/'],
            'wifi_mac'      => ['nullable', 'regex:/^([0-9A-Fa-f]{2}[:\-]){5}[0-9A-Fa-f]{2}$/'],
        ]);

        $ipAddress = IpAddress::findOrFail($validated['ip_address_id']);

        if ($ipAddress->status !== 'available') {
            return back()->with('error', 'This IP is not available for allocation.');
        }

        // Release any accidental lingering active allocation
        IpAllocation::where('ip_address_id', $ipAddress->id)
            ->where('status', 'active')
            ->update(['status' => 'released', 'date_released' => now()]);

        $allocation = IpAllocation::create([
            'ip_address_id'  => $validated['ip_address_id'],
            'user_id'        => $validated['user_id'],
            'asset_id'       => $validated['asset_id'] ?? null,
            'date_allocated' => $validated['date_allocated'],
            'notes'          => $validated['notes'] ?? null,
            'status'         => 'active',
            'allocated_by'   => auth()->id(),
        ]);

       if (!empty($validated['asset_id'])) {

            AssetNetworkDetail::updateOrCreate(
                [
                    'asset_id' => $validated['asset_id']
                ],
                [
                    'ethernet_mac' => $validated['ethernet_mac'] ?? null,
                    'wifi_mac'     => $validated['wifi_mac'] ?? null,
                ]
            );
        }
        $ipAddress->update(['status' => 'allocated']);

        $user = $allocation->user;
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'module'      => 'IP Allocation',
            'action'      => 'allocated',
            'description' => "Allocated {$ipAddress->ip_address} to {$user->name}",
        ]);

        return back()->with('success', "IP {$ipAddress->ip_address} allocated to {$user->name}.");
    }

    // ─── Edit allocation ──────────────────────────────────────────────────────

    public function update(Request $request, IpAllocation $ipAllocation): RedirectResponse
    {
        $validated = $request->validate([
            'ethernet_mac'  => ['nullable', 'regex:/^([0-9A-Fa-f]{2}[:\-]){5}[0-9A-Fa-f]{2}$/'],
            'wifi_mac'      => ['nullable', 'regex:/^([0-9A-Fa-f]{2}[:\-]){5}[0-9A-Fa-f]{2}$/'],

            'date_allocated'=> 'required|date',
            'notes'         => 'nullable|string|max:500',
            'status'        => 'required|in:active,suspended',
            'asset_id' => 'nullable|exists:assets,id',
        ]);

        $ipAllocation->update($validated);
        if ($ipAllocation->asset_id) {

            AssetNetworkDetail::updateOrCreate(
                [
                    'asset_id' => $ipAllocation->asset_id
                ],
                [
                    'ethernet_mac' => $request->ethernet_mac,
                    'wifi_mac'     => $request->wifi_mac,
                ]
            );
        }
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'module'      => 'IP Allocation',
            'action'      => 'updated',
            'description' => "Updated allocation of {$ipAllocation->ipAddress->ip_address} for {$ipAllocation->user->name}",
        ]);

        return back()->with('success', 'Allocation updated successfully.');
    }

    // ─── Release / deallocate ─────────────────────────────────────────────────

    public function release(Request $request,IpAllocation $ipAllocation)
    {
        $request->validate([
            'date_released' => 'required|date',
            'release_notes' => 'nullable|string|max:500',
        ]);

        $ipAllocation->update([
            'status' => 'released',
            'date_released' => $request->date_released,
            'release_notes' => $request->release_notes,
            'released_by' => auth()->id(),
        ]);

        $ipAllocation->ipAddress()->update([
            'status' => 'available'
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'module' => 'IP Allocation',
            'action' => 'released',
            'description' =>
                "Released {$ipAllocation->ipAddress->ip_address}",
        ]);

        return back()->with(
            'success',
            'IP released successfully.'
        );
    }

    // ─── Delete allocation record ─────────────────────────────────────────────

    public function destroy(IpAllocation $ipAllocation): RedirectResponse
    {
        if(auth()->user()->role?->name !== 'super_admin')
        {
            abort(403);
        }
        if ($ipAllocation->status === 'active') {
            $ipAllocation->ipAddress->update(['status' => 'available']);
        }

        $info = "{$ipAllocation->ipAddress->ip_address} / {$ipAllocation->user->name}";
        $ipAllocation->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'module'      => 'IP Allocation',
            'action'      => 'deleted',
            'description' => "Deleted allocation record: {$info}",
        ]);

        return back()->with('success', 'Allocation record deleted.');
    }

    // ─── Allocation history for one IP ────────────────────────────────────────

    public function history(IpAddress $ipAddress): View
    {
        $allocations = $ipAddress->allocations()
            ->with(['user', 'allocatedBy'])
            ->latest()
            ->paginate(20);

        return view('admin.ip-allocation.history', compact('ipAddress', 'allocations'));
    }

    // ─── Export allocations ───────────────────────────────────────────────────

    public function export(Request $request): Response
    {
        $allocations = IpAllocation::with(['ipAddress', 'user', 'allocatedBy'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $filename = 'ip_allocations_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($allocations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'IP Address', 'Employee Name', 'Ethernet MAC', 'WiFi MAC',
                'DNS Override', 'Device Name', 'Device Type',
                'Date Allocated', 'Date Released', 'Status',
                'Allocated By', 'Notes',
            ]);

            foreach ($allocations as $a) {
                fputcsv($handle, [
                    $a->ipAddress->ip_address,
                    $a->user->name,
                    $a->ethernet_mac,
                    $a->wifi_mac,
                    $a->dns_override,
                    $a->device_name,
                    $a->device_type,
                    $a->date_allocated?->format('Y-m-d'),
                    $a->date_released?->format('Y-m-d'),
                    $a->status,
                    $a->allocatedBy?->name,
                    $a->notes,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function print($id)
    {
        // Load the allocation with necessary relationships
        $allocation = \App\Models\IpAllocation::with(['user', 'ipAddress', 'allocatedBy'])->findOrFail($id);

        return view('admin.ip-allocation.print', compact('allocation'));
    }
}
