<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class IpAddressController extends Controller
{
    public function index(Request $request): View
    {
        $query = IpAddress::withCount('allocations')
            ->with('activeAllocation.user')
            ->when($request->search, fn($q) => $q->where('ip_address', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%")
                ->orWhere('vlan', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->network_type, fn($q) => $q->where('network_type', $request->network_type));

        $ipAddresses = $query->orderBy('ip_address')->paginate(20)->withQueryString();

        return view('admin.ip-addresses.index', compact('ipAddresses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ip_address'   => 'required|ip|unique:ip_addresses,ip_address',
            'subnet_mask'  => 'nullable|string|max:45',
            'gateway'      => 'nullable|ip',
            'dns_primary'  => 'nullable|ip',
            'dns_secondary'=> 'nullable|ip',
            'network_type' => 'required|in:LAN,WAN,WiFi,VPN',
            'vlan'         => 'nullable|string|max:50',
            'description'  => 'nullable|string|max:500',
            'status'       => 'required|in:available,reserved,decommissioned',
        ]);

        $ip = IpAddress::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'module'  => 'IP Address',
            'action'  => 'created',
            'description' => "Added IP {$ip->ip_address}",
        ]);

        return back()->with('success', "IP address {$ip->ip_address} added successfully.");
    }

    public function update(Request $request, IpAddress $ipAddress): RedirectResponse
    {
        $validated = $request->validate([
            'ip_address'   => "required|ip|unique:ip_addresses,ip_address,{$ipAddress->id}",
            'subnet_mask'  => 'nullable|string|max:45',
            'gateway'      => 'nullable|ip',
            'dns_primary'  => 'nullable|ip',
            'dns_secondary'=> 'nullable|ip',
            'network_type' => 'required|in:LAN,WAN,WiFi,VPN',
            'vlan'         => 'nullable|string|max:50',
            'description'  => 'nullable|string|max:500',
            'status'       => 'required|in:available,reserved,decommissioned',
        ]);

        // Prevent changing status to available/reserved if actively allocated
        if ($ipAddress->status === 'allocated' && in_array($validated['status'], ['available', 'reserved'])) {
            return back()->withErrors(['status' => 'Cannot change status — IP is currently allocated.']);
        }

        $ipAddress->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'module'  => 'IP Address',
            'action'  => 'updated',
            'description' => "Updated IP {$ipAddress->ip_address}",
        ]);

        return back()->with('success', "IP address updated successfully.");
    }

    public function destroy(IpAddress $ipAddress): RedirectResponse
    {
        if ($ipAddress->status === 'allocated') {
            return back()->with('error', 'Cannot delete an allocated IP address.');
        }

        $ip = $ipAddress->ip_address;
        $ipAddress->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'module'  => 'IP Address',
            'action'  => 'deleted',
            'description' => "Deleted IP {$ip}",
        ]);

        return back()->with('success', "IP address {$ip} deleted.");
    }

    // ─── Import ───────────────────────────────────────────────────────────────

    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $file   = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // skip header row

        $imported = 0;
        $skipped  = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 1 || empty(trim($row[0]))) {
                $skipped++;
                continue;
            }

            $data = [
                'ip_address'   => trim($row[0] ?? ''),
                'subnet_mask'  => trim($row[1] ?? '') ?: null,
                'gateway'      => trim($row[2] ?? '') ?: null,
                'dns_primary'  => trim($row[3] ?? '') ?: null,
                'dns_secondary'=> trim($row[4] ?? '') ?: null,
                'network_type' => in_array(trim($row[5] ?? ''), ['LAN','WAN','WiFi','VPN']) ? trim($row[5]) : 'LAN',
                'vlan'         => trim($row[6] ?? '') ?: null,
                'description'  => trim($row[7] ?? '') ?: null,
                'status'       => in_array(trim($row[8] ?? ''), ['available','reserved','decommissioned']) ? trim($row[8]) : 'available',
            ];

            if (filter_var($data['ip_address'], FILTER_VALIDATE_IP) &&
                !IpAddress::where('ip_address', $data['ip_address'])->exists()) {
                IpAddress::create($data);
                $imported++;
            } else {
                $skipped++;
            }
        }

        fclose($handle);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'module'  => 'IP Address',
            'action'  => 'imported',
            'description' => "Imported {$imported} IPs, skipped {$skipped}",
        ]);

        return back()->with('success', "Import complete — {$imported} added, {$skipped} skipped.");
    }

    // ─── Export ───────────────────────────────────────────────────────────────

    public function export(Request $request): Response
    {
        $ipAddresses = IpAddress::with('activeAllocation.user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('ip_address')
            ->get();

        $filename = 'ip_addresses_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($ipAddresses) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'IP Address', 'Subnet Mask', 'Gateway', 'DNS Primary', 'DNS Secondary',
                'Network Type', 'VLAN', 'Description', 'Status',
                'Allocated To', 'Date Allocated',
            ]);

            foreach ($ipAddresses as $ip) {
                $allocation = $ip->activeAllocation;
                fputcsv($handle, [
                    $ip->ip_address,
                    $ip->subnet_mask,
                    $ip->gateway,
                    $ip->dns_primary,
                    $ip->dns_secondary,
                    $ip->network_type,
                    $ip->vlan,
                    $ip->description,
                    $ip->status,
                    $allocation?->user?->name,
                    $allocation?->date_allocated?->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
