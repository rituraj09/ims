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
                                {{ $a->user->designation->name}}
                            </div>
                        </td>
                        <td>
                            <code class="fw-semibold">{{ $a->ipAddress->ip_address }}</code>
                            <div class="small text-muted">{{ $a->ipAddress->network_type }}</div>
                        </td>
                        <td>
                            {{ $a->asset?->networkDetail?->ethernet_mac ?? '—' }}
                        </td>
                        <td>
                            {{ $a->asset?->networkDetail?->wifi_mac ?? '—' }}
                        </td>
                        <td>
                            <div>{{ $a->asset?->name }}</div>
                            @if($a->asset?->asset_tag)
                                <div class="small text-muted">{{ $a->asset?->asset_tag }}</div>
                            @endif
                        </td>
                        <td>{{ $a->date_allocated?->format('d M Y') }}</td>
                        <td>{{ $a->date_released?->format('d M Y') ?? '—' }}</td>
                        <td>{!! $a->status_badge !!}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                {{-- View Button --}}
                                <button type="button"
                                        class="btn btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewAllocationModal"

                                        data-id="{{ $a->id }}"
                                        data-user="{{ $a->user->name }}"
                                        data-designation="{{ $a->user->designation?->name }}"
                                        data-asset="{{ $a->asset?->name }}"
                                        data-tag="{{ $a->asset?->asset_tag }}"
                                        data-serial="{{ $a->asset?->serial_no }}"
                                        data-ip="{{ $a->ipAddress->ip_address }}"
                                        data-ethernet="{{ $a->asset?->networkDetail?->ethernet_mac }}"
                                        data-wifi="{{ $a->asset?->networkDetail?->wifi_mac }}"
                                        data-status="{{ ucfirst($a->status) }}"
                                        data-allocated="{{ $a->date_allocated?->format('d M Y') }}"
                                        data-released="{{ $a->date_released?->format('d M Y') }}"
                                        data-notes="{{ $a->notes }}"
                                        data-release-notes="{{ $a->release_notes }}"
                                        data-dns="{{ $a->dns_override }}"
                                        data-allocated-by="{{ $a->allocatedBy?->name }}"
                                        data-released-by="{{ $a->releasedBy?->name }}"
                                        data-created="{{ $a->created_at?->format('d M Y H:i') }}"
                                        data-updated="{{ $a->updated_at?->format('d M Y H:i') }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                {{-- Edit Button --}}
                                @if($a->status === 'active' || $a->status === 'suspended')
                                    <button type="button"
                                        class="btn btn-outline-primary"
                                        title="Edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editAllocationModal"
                                        data-id="{{ $a->id }}"
                                        data-user="{{ $a->user->name }}"
                                        data-ip="{{ $a->ipAddress->ip_address }}"
                                        data-date="{{ $a->date_allocated?->format('Y-m-d') }}"
                                        data-status="{{ $a->status }}"
                                        data-notes="{{ $a->notes }}"
                                        data-asset-id="{{ $a->asset_id }}"
                                        data-asset-name="{{ $a->asset?->name }}"
                                        data-asset-tag="{{ $a->asset?->asset_tag }}"
                                        data-ethernet="{{ $a->asset?->networkDetail?->ethernet_mac }}"
                                        data-wifi="{{ $a->asset?->networkDetail?->wifi_mac }}"
                                        >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                                {{-- FIX 4: was admin.ip-allocation.history → admin.ip-addresses.allocations.history --}}
                                <a href="{{ route('admin.ip-addresses.allocations.history', $a->ip_address_id) }}"
                                   class="btn btn-outline-info" title="IP History">
                                    <i class="fas fa-history"></i>
                                </a>

                                {{-- Release  Button--}}
                                @if($a->status === 'active')
                                <button type="button"
                                        class="btn btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#releaseModal"
                                        data-id="{{ $a->id }}"
                                        data-user="{{ $a->user->name }}"
                                        data-ip="{{ $a->ipAddress->ip_address }}"
                                        title="Release IP">
                                    <i class="fas fa-unlink"></i>
                                </button>
                                @endif
                                {{-- Print  Button--}}
                                <a href="{{ route('admin.ip-addresses.allocations.print', $a->id) }}"
                                class="btn btn-outline-dark"
                                title="Print Handover Form"
                                target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                {{-- Delete  Button--}}
                                @if($role == 'super_admin')
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
                                @endif

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
{{-- Release Modal --}}
<div class="modal fade" id="releaseModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="releaseForm">
            @csrf

            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-unlink me-2"></i>
                        Release IP Allocation
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-warning">
                        <strong>Employee:</strong>
                        <span id="releaseUser"></span>
                        <br>

                        <strong>IP:</strong>
                        <code id="releaseIp"></code>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Release Date
                        </label>

                        <input type="date"
                               name="date_released"
                               value="{{ date('Y-m-d') }}"
                               class="form-control"
                               required>
                    </div>

                    <div>
                        <label class="form-label">
                            Release Remarks
                        </label>

                        <textarea name="release_notes"
                                  rows="3"
                                  class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-warning">
                        <i class="fas fa-check me-1"></i>
                        Release
                    </button>

                </div>

            </div>
        </form>
    </div>
</div>


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

                    {{-- Employee & Asset --}}
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">
                            <i class="fas fa-user me-2"></i>
                            Employee & Asset Information
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Employee <span class="text-danger">*</span>
                                    </label>

                                    <select name="user_id"
                                            id="userSelect"
                                            class="form-select"
                                            required>
                                        <option value="">Select Employee</option>

                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Assigned Asset
                                    </label>

                                    <select name="asset_id"
                                            id="assetSelect"
                                            class="form-select">
                                        <option value="">Select Asset</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Asset Details --}}
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">
                            <i class="fas fa-desktop me-2"></i>
                            Asset Details
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Sub Category</label>
                                    <input type="text"
                                        id="assetSubCategory"
                                        class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Brand</label>
                                    <input type="text"
                                        id="assetBrand"
                                        class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Model</label>
                                    <input type="text"
                                        id="assetModel"
                                        class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Serial No</label>
                                    <input type="text"
                                        id="assetSerial"
                                        class="form-control"
                                        readonly>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Network Information --}}
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">
                            <i class="fas fa-network-wired me-2"></i>
                            Network Information
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Ethernet MAC
                                    </label>

                                    <input type="text"
                                        name="ethernet_mac"
                                        id="ethernetMac"
                                        class="form-control"
                                        placeholder="AA:BB:CC:DD:EE:FF">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        WiFi MAC
                                    </label>

                                    <input type="text"
                                        name="wifi_mac"
                                        id="wifiMac"
                                        class="form-control"
                                        placeholder="AA:BB:CC:DD:EE:FF">
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- IP Configuration --}}
                    <div class="card">
                        <div class="card-header bg-light fw-bold">
                            <i class="fas fa-globe me-2"></i>
                            IP Configuration
                        </div>

                        <div class="card-body">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        IP Address
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="ip_address_id"
                                            id="ipSelect"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Select Available IP
                                        </option>

                                        @foreach($availableIps as $ip)
                                            <option value="{{ $ip->id }}"
                                                    data-gateway="{{ $ip->gateway }}"
                                                    data-dns="{{ $ip->dns_primary }}">

                                                {{ $ip->ip_address }}

                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Date Allocated
                                    </label>

                                    <input type="date"
                                        name="date_allocated"
                                        value="{{ date('Y-m-d') }}"
                                        class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        Notes
                                    </label>

                                    <textarea name="notes"
                                            rows="3"
                                            class="form-control"></textarea>
                                </div>

                            </div>

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
{{-- View Allocation Modal --}}



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
                        <div class="alert alert-light border">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Employee:</strong>
                                    <span id="editUserName"></span>
                                </div>

                                <div class="col-md-6">
                                    <strong>IP Address:</strong>
                                    <code id="editIpDisplay"></code>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">

                            {{-- Asset --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Asset
                                </label>

                                <input
                                    type="text"
                                    id="editAssetName"
                                    class="form-control"
                                    readonly>
                            </div>

                            {{-- Asset Tag --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Asset Tag
                                </label>

                                <input
                                    type="text"
                                    id="editAssetTag"
                                    class="form-control"
                                    readonly>
                            </div>

                            {{-- Ethernet MAC --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Ethernet MAC
                                </label>

                                <input
                                    type="text"
                                    name="ethernet_mac"
                                    id="edit_ethernet_mac"
                                    class="form-control"
                                    placeholder="AA:BB:CC:DD:EE:FF">
                            </div>

                            {{-- WiFi MAC --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    WiFi MAC
                                </label>

                                <input
                                    type="text"
                                    name="wifi_mac"
                                    id="edit_wifi_mac"
                                    class="form-control"
                                    placeholder="AA:BB:CC:DD:EE:FF">
                            </div>



                            {{-- Allocation Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Date Allocated
                                </label>

                                <input
                                    type="date"
                                    name="date_allocated"
                                    id="edit_date_allocated"
                                    class="form-control"
                                    required>
                            </div>



                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    id="edit_status"
                                    class="form-select">

                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>

                                </select>
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Notes
                                </label>

                                <textarea
                                    name="notes"
                                    id="edit_notes"
                                    class="form-control"
                                    rows="3"></textarea>
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



{{-- View Allocation Modal --}}

<div class="modal fade" id="viewAllocationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

        <div class="modal-header bg-info text-white">
            <h5 class="modal-title">
                <i class="fas fa-eye me-2"></i>
                Allocation Details
            </h5>

            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
            </button>
        </div>

        <div class="modal-body">

            {{-- Employee Information --}}
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-user me-2"></i>
                    Employee Information
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">
                                Employee Name
                            </label>

                            <div class="fw-semibold fs-6"
                                 id="view_employee">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">
                                Designation
                            </label>

                            <div class="fw-semibold"
                                 id="view_designation">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Asset Information --}}
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-desktop me-2"></i>
                    Asset Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                Asset Name
                            </label>

                            <div class="fw-semibold"
                                 id="view_asset">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                Asset Tag
                            </label>

                            <div class="fw-semibold"
                                 id="view_asset_tag">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                Serial Number
                            </label>

                            <div class="fw-semibold"
                                 id="view_serial">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- Network Information --}}
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-network-wired me-2"></i>
                    Network Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                IP Address
                            </label>

                            <div>
                                <code class="fs-6"
                                      id="view_ip">
                                </code>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                Ethernet MAC
                            </label>

                            <div class="fw-semibold"
                                 id="view_ethernet">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">
                                WiFi MAC
                            </label>

                            <div class="fw-semibold"
                                 id="view_wifi">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- Allocation Information --}}
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-link me-2"></i>
                    Allocation Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">
                                Status
                            </label>

                            <div id="view_status"></div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">
                                Date Allocated
                            </label>

                            <div class="fw-semibold"
                                 id="view_allocated_date">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">
                                Date Released
                            </label>

                            <div class="fw-semibold"
                                 id="view_released_date">
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">
                            Allocation Notes
                        </label>

                        <div class="border rounded p-2 bg-light"
                             id="view_notes">
                        </div>
                    </div>

                </div>
            </div>

            {{-- Release Information --}}
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-unlink me-2"></i>
                    Release Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">
                                Released By
                            </label>

                            <div class="fw-semibold"
                                 id="view_released_by">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">
                                Release Date
                            </label>

                            <div class="fw-semibold"
                                 id="view_release_date">
                            </div>
                        </div>

                    </div>

                    <div>
                        <label class="text-muted small">
                            Release Remarks
                        </label>

                        <div class="border rounded p-2 bg-light"
                             id="view_release_notes">
                        </div>
                    </div>

                </div>
            </div>

            {{-- Audit Trail --}}
            <div class="card">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-history me-2"></i>
                    Audit Information
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3">
                            <label class="text-muted small">
                                Allocated By
                            </label>

                            <div class="fw-semibold"
                                 id="view_allocated_by">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="text-muted small">
                                Created At
                            </label>

                            <div class="fw-semibold"
                                 id="view_created_at">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="text-muted small">
                                Updated At
                            </label>

                            <div class="fw-semibold"
                                 id="view_updated_at">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="text-muted small">
                                Allocation ID
                            </label>

                            <div class="fw-semibold"
                                 id="view_id">
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                Close
            </button>
        </div>

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
    document.getElementById('edit_date_allocated').value       = btn.dataset.date        ?? '';
    document.getElementById('edit_status').value               = btn.dataset.status      ?? 'active';
    document.getElementById('edit_notes').value                = btn.dataset.notes       ?? '';
});
    const userAssetsUrl = "{{ url('admin/ajax/ip-allocations/user-assets') }}";

document.getElementById('userSelect').addEventListener('change', function () {
    let userId = this.value;

    if (!userId) return;

    fetch(`${userAssetsUrl}/${userId}`)
        .then(response => response.json())
        .then(data => {
                let assetSelect = document.getElementById('assetSelect');

                assetSelect.innerHTML =
                    '<option value="">Select Asset</option>';

                data.forEach(asset => {

                    assetSelect.innerHTML += `
                        <option value="${asset.id}">
                            ${asset.asset_tag ?? ''} - ${asset.name}
                        </option>
                    `;
                });

                window.assetData = {};

                data.forEach(asset => {
                    window.assetData[asset.id] = asset;
                });
            });
    });
        assetSelect.addEventListener('change', function () {

            const asset = window.assetData[this.value];

            if (!asset) return;

            document.getElementById('assetSubCategory').value =
                asset.sub_category_name ?? '';

            document.getElementById('assetBrand').value =
                asset.make_brand ?? '';

            document.getElementById('assetModel').value =
                asset.model ?? '';

            document.getElementById('assetSerial').value =
                asset.serial_no ?? '';

            document.getElementById('ethernetMac').value =
                asset.network_detail?.ethernet_mac ?? '';

            document.getElementById('wifiMac').value =
                asset.network_detail?.wifi_mac ?? '';
        });
    document.getElementById('editAllocationModal').addEventListener('show.bs.modal', function (e) {

        const btn = e.relatedTarget;

        document.getElementById('editUserName').textContent =
            btn.dataset.user || '';

        document.getElementById('editIpDisplay').textContent =
            btn.dataset.ip || '';

        document.getElementById('editAssetName').value =
            btn.dataset.assetName || '';

        document.getElementById('editAssetTag').value =
            btn.dataset.assetTag || '';

        document.getElementById('edit_ethernet_mac').value =
            btn.dataset.ethernet || '';

        document.getElementById('edit_wifi_mac').value =
            btn.dataset.wifi || '';


        document.getElementById('edit_date_allocated').value =
            btn.dataset.date || '';



        document.getElementById('edit_status').value =
            btn.dataset.status || 'active';

        document.getElementById('edit_notes').value =
            btn.dataset.notes || '';
    });
    document.getElementById('releaseModal')
    .addEventListener('show.bs.modal', function(e){

        const btn = e.relatedTarget;

        const baseUrl =
        "{{ rtrim(route('admin.ip-addresses.allocations.release', ['ipAllocation' => '__ID__']), '/') }}";

        document.getElementById('releaseForm').action =
            baseUrl.replace('__ID__', btn.dataset.id);

        document.getElementById('releaseUser').textContent =
            btn.dataset.user;

        document.getElementById('releaseIp').textContent =
            btn.dataset.ip;
    });

    document.getElementById('viewAllocationModal')
.addEventListener('show.bs.modal', function(e){

    const btn = e.relatedTarget;

    document.getElementById('view_id').textContent = btn.dataset.id ?? '';
    document.getElementById('view_employee').textContent = btn.dataset.user ?? '';
    document.getElementById('view_designation').textContent = btn.dataset.designation ?? '';

    document.getElementById('view_asset').textContent = btn.dataset.asset ?? '-';
    document.getElementById('view_asset_tag').textContent = btn.dataset.tag ?? '-';
    document.getElementById('view_serial').textContent = btn.dataset.serial ?? '-';

    document.getElementById('view_ip').textContent = btn.dataset.ip ?? '-';
    document.getElementById('view_ethernet').textContent = btn.dataset.ethernet ?? '-';
    document.getElementById('view_wifi').textContent = btn.dataset.wifi ?? '-';

    document.getElementById('view_status').innerHTML =
        `<span class="badge bg-${btn.dataset.status === 'Active' ? 'success' : 'secondary'}">${btn.dataset.status}</span>`;

    document.getElementById('view_allocated_date').textContent = btn.dataset.allocated ?? '-';
    document.getElementById('view_released_date').textContent = btn.dataset.released ?? '-';

    document.getElementById('view_notes').textContent = btn.dataset.notes ?? '-';

    document.getElementById('view_released_by').textContent = btn.dataset.releasedBy ?? '-';
    document.getElementById('view_release_date').textContent = btn.dataset.released ?? '-';
    document.getElementById('view_release_notes').textContent = btn.dataset.releaseNotes ?? '-';

    document.getElementById('view_allocated_by').textContent = btn.dataset.allocatedBy ?? '-';
    document.getElementById('view_created_at').textContent = btn.dataset.created ?? '-';
    document.getElementById('view_updated_at').textContent = btn.dataset.updated ?? '-';
});
</script>
@endpush
