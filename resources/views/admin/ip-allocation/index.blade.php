{{-- resources/views/admin/ip-allocation/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Employee Wise IP Allocation')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.ip-addresses.index') }}">IP Address Pool</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Employee Allocation</span>
@endsection

@section('page-title', 'Employee Wise IP Allocation')
@section('page-subtitle', 'Assign and track IP addresses per employee')

@section('page-actions')
    {{-- FIX 1: was admin.ip-allocation.export → admin.ip-addresses.allocations.export --}}
    <a href="{{ route('admin.ip-addresses.allocations.export') }}" class="btn btn-outline-success">
        <i class="fas fa-file-csv me-1"></i> Export
    </a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal">
        <i class="fas fa-plus me-1"></i> Assign IP
    </button>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        {{-- FIX 2: added explicit action to filter form --}}
        <form method="GET" action="{{ route('admin.ip-addresses.allocations.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3 col-12">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Employee name or IP address…"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-6">
                <select name="user_id" class="form-select form-select-sm">
                    <option value="">All Employees</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            @selected(request('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="active"    @selected(request('status') === 'active')>Active</option>
                    <option value="released"  @selected(request('status') === 'released')>Released</option>
                    <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <input type="date" name="date_from" class="form-control form-control-sm"
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2 col-6">
                <input type="date" name="date_to" class="form-control form-control-sm"
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1 col-12 d-flex gap-1">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-search"></i> Search
                </button>
                {{-- FIX 3: was admin.ip-allocation.index → admin.ip-addresses.allocations.index --}}
                <a href="{{ route('admin.ip-addresses.allocations.index') }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex align-items-center">
        <i class="fas fa-clock-rotate-left me-2 text-primary"></i>
        Employee Wise IP Allocation
        <span class="badge bg-secondary ms-2">{{ $allocations->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sl.</th>
                        <th>Employee</th>
                        <th>IP Address</th>
                        <th>Ethernet MAC</th>
                        <th>WiFi MAC</th>
                        <th>Device</th>
                        <th>Date Allocated</th>
                        <th>Date Released</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allocations as $i => $a)
                    <tr class="{{ $a->status === 'suspended' ? 'table-warning' : '' }}">
                        <td class="text-muted">{{ $allocations->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $a->user->name }}</div>
                            <div class="small text-muted">
                                {{ $a->user->designation ?? $a->user->email }}
                            </div>
                        </td>
                        <td>
                            <code class="fw-semibold">{{ $a->ipAddress->ip_address }}</code>
                            <div class="small text-muted">{{ $a->ipAddress->network_type }}</div>
                        </td>
                        <td>{{ $a->ethernet_mac ?? '—' }}</td>
                        <td>{{ $a->wifi_mac ?? '—' }}</td>
                        <td>
                            <div>{{ $a->device_name ?? '—' }}</div>
                            @if($a->device_type)
                                <div class="small text-muted">{{ $a->device_type }}</div>
                            @endif
                        </td>
                        <td>{{ $a->date_allocated?->format('d M Y') }}</td>
                        <td>{{ $a->date_released?->format('d M Y') ?? '—' }}</td>
                        <td>{!! $a->status_badge !!}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">

                                {{-- Edit --}}
                                <button type="button"
                                    class="btn btn-outline-primary"
                                    title="Edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAllocationModal"
                                    data-id="{{ $a->id }}"
                                    data-user="{{ $a->user->name }}"
                                    data-ip="{{ $a->ipAddress->ip_address }}"
                                    data-ethernet="{{ $a->ethernet_mac }}"
                                    data-wifi="{{ $a->wifi_mac }}"
                                    data-dns="{{ $a->dns_override }}"
                                    data-device-name="{{ $a->device_name }}"
                                    data-device-type="{{ $a->device_type }}"
                                    data-date="{{ $a->date_allocated?->format('Y-m-d') }}"
                                    data-status="{{ $a->status }}"
                                    data-notes="{{ $a->notes }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- FIX 4: was admin.ip-allocation.history → admin.ip-addresses.allocations.history --}}
                                <a href="{{ route('admin.ip-addresses.allocations.history', $a->ip_address_id) }}"
                                   class="btn btn-outline-info" title="IP History">
                                    <i class="fas fa-history"></i>
                                </a>

                                {{-- Release --}}
                                @if($a->status === 'active')
                                <form method="POST"
                                    {{-- FIX 5: was admin.ip-allocation.release → admin.ip-addresses.allocations.release --}}
                                    action="{{ route('admin.ip-addresses.allocations.release', $a->id) }}"
                                    onsubmit="return confirm('Release IP {{ $a->ipAddress->ip_address }} from {{ $a->user->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning" title="Release IP">
                                        <i class="fas fa-unlink"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Delete --}}
                                <form method="POST"
                                    {{-- FIX 6: was admin.ip-allocation.destroy → admin.ip-addresses.allocations.destroy --}}
                                    action="{{ route('admin.ip-addresses.allocations.destroy', $a->id) }}"
                                    onsubmit="return confirm('Delete this allocation record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            No allocations found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($allocations->hasPages())
    <div class="card-footer">
        {{ $allocations->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════
     MODALS
═══════════════════════════════════ --}}

{{-- Assign IP Modal --}}
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        {{-- FIX 7: was admin.ip-allocation.store → admin.ip-addresses.allocations.store --}}
        <form method="POST" action="{{ route('admin.ip-addresses.allocations.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Assign IP to Employee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Employee <span class="text-danger">*</span>
                            </label>
                            <select name="user_id" class="form-select" required>
                                <option value="">— Select Employee —</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                IP Address <span class="text-danger">*</span>
                            </label>
                            <select name="ip_address_id" class="form-select" id="ipSelect" required>
                                <option value="">— Select Available IP —</option>
                                @foreach($availableIps as $ip)
                                    <option value="{{ $ip->id }}"
                                        data-gateway="{{ $ip->gateway }}"
                                        data-dns="{{ $ip->dns_primary }}">
                                        {{ $ip->ip_address }}
                                        @if($ip->subnet_mask) / {{ $ip->subnet_mask }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ethernet MAC</label>
                            <input type="text" name="ethernet_mac" class="form-control"
                                   placeholder="AA:BB:CC:DD:EE:FF">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">WiFi MAC</label>
                            <input type="text" name="wifi_mac" class="form-control"
                                   placeholder="AA:BB:CC:DD:EE:FF">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DNS Override</label>
                            <input type="text" name="dns_override" class="form-control"
                                   id="dnsOverride"
                                   placeholder="Leave blank to use IP pool default">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Date Allocated <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="date_allocated" class="form-control"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Device Name</label>
                            <input type="text" name="device_name" class="form-control"
                                   placeholder="e.g. DESKTOP-JD001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Device Type</label>
                            <select name="device_type" class="form-select">
                                <option value="">— Optional —</option>
                                <option>Desktop</option>
                                <option>Laptop</option>
                                <option>Server</option>
                                <option>Printer</option>
                                <option>Switch</option>
                                <option>Router</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Optional…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Assign
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Allocation Modal --}}
<div class="modal fade" id="editAllocationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editAllocationForm" action="">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Allocation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3 d-flex align-items-center gap-3">
                        <i class="fas fa-info-circle text-primary fs-5"></i>
                        <div>
                            <span class="fw-semibold" id="editUserName"></span> &rarr;
                            <code id="editIpDisplay"></code>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ethernet MAC</label>
                            <input type="text" name="ethernet_mac" id="edit_ethernet_mac" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">WiFi MAC</label>
                            <input type="text" name="wifi_mac" id="edit_wifi_mac" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">DNS Override</label>
                            <input type="text" name="dns_override" id="edit_dns_override" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Date Allocated <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="date_allocated" id="edit_date_allocated"
                                   class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Device Name</label>
                            <input type="text" name="device_name" id="edit_device_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Device Type</label>
                            <select name="device_type" id="edit_device_type" class="form-select">
                                <option value="">— Optional —</option>
                                <option>Desktop</option>
                                <option>Laptop</option>
                                <option>Server</option>
                                <option>Printer</option>
                                <option>Switch</option>
                                <option>Router</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" id="edit_notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-fill DNS hint when IP is selected in assign modal
document.getElementById('ipSelect')?.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    const dns = opt.dataset.dns;
    document.getElementById('dnsOverride').placeholder = dns
        ? `Default: ${dns}`
        : 'Leave blank to use IP pool default';
});

// Populate edit modal — FIX 8: replaced hardcoded URL with route-based URL
document.getElementById('editAllocationModal').addEventListener('show.bs.modal', function (e) {
    const btn  = e.relatedTarget;
    const form = document.getElementById('editAllocationForm');

    // FIX: Build URL from base route pattern instead of hardcoded path
    const baseUrl = "{{ rtrim(route('admin.ip-addresses.allocations.update', ['ipAllocation' => '__ID__']), '/') }}";
    form.action = baseUrl.replace('__ID__', btn.dataset.id);

    document.getElementById('editUserName').textContent        = btn.dataset.user        ?? '';
    document.getElementById('editIpDisplay').textContent       = btn.dataset.ip          ?? '';
    document.getElementById('edit_ethernet_mac').value         = btn.dataset.ethernet    ?? '';
    document.getElementById('edit_wifi_mac').value             = btn.dataset.wifi        ?? '';
    document.getElementById('edit_dns_override').value         = btn.dataset.dns         ?? '';
    document.getElementById('edit_date_allocated').value       = btn.dataset.date        ?? '';
    document.getElementById('edit_device_name').value          = btn.dataset.deviceName  ?? '';
    document.getElementById('edit_device_type').value          = btn.dataset.deviceType  ?? '';
    document.getElementById('edit_status').value               = btn.dataset.status      ?? 'active';
    document.getElementById('edit_notes').value                = btn.dataset.notes       ?? '';
});
</script>
@endpush
