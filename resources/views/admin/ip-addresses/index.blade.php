{{-- resources/views/admin/ip-addresses/index.blade.php --}}
@extends('layouts.app')
@section('title', 'IP Address Pool')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">IP Address Pool</span>
@endsection

@section('page-title', 'IP Address Pool')
@section('page-subtitle', 'Manage available IP addresses, subnets and gateways')

@section('page-actions')
    <a href="{{ route('admin.ip-addresses.export') }}" class="btn btn-outline-success">
        <i class="fas fa-file-csv me-1"></i> Export
    </a>
    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="fas fa-file-upload me-1"></i> Import
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIpModal">
        <i class="fas fa-plus me-1"></i> Add IP
    </button>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-times-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

{{-- Stats Row --}}
<div class="row g-3 mb-3">
    @php
        $counts = $ipAddresses->getCollection()->groupBy('status');
    @endphp
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-success bg-opacity-10 text-center py-2">
            <div class="fs-4 fw-bold text-success">{{ \App\Models\IpAddress::where('status','available')->count() }}</div>
            <div class="small text-muted">Available</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-primary bg-opacity-10 text-center py-2">
            <div class="fs-4 fw-bold text-primary">{{ \App\Models\IpAddress::where('status','allocated')->count() }}</div>
            <div class="small text-muted">Allocated</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-warning bg-opacity-10 text-center py-2">
            <div class="fs-4 fw-bold text-warning">{{ \App\Models\IpAddress::where('status','reserved')->count() }}</div>
            <div class="small text-muted">Reserved</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 bg-secondary bg-opacity-10 text-center py-2">
            <div class="fs-4 fw-bold text-secondary">{{ \App\Models\IpAddress::count() }}</div>
            <div class="small text-muted">Total</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4 col-12">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search IP, description, VLAN…" value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="available"      @selected(request('status')=='available')>Available</option>
                    <option value="allocated"      @selected(request('status')=='allocated')>Allocated</option>
                    <option value="reserved"       @selected(request('status')=='reserved')>Reserved</option>
                    <option value="decommissioned" @selected(request('status')=='decommissioned')>Decommissioned</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="network_type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="LAN"  @selected(request('network_type')=='LAN')>LAN</option>
                    <option value="WAN"  @selected(request('network_type')=='WAN')>WAN</option>
                    <option value="WiFi" @selected(request('network_type')=='WiFi')>WiFi</option>
                    <option value="VPN"  @selected(request('network_type')=='VPN')>VPN</option>
                </select>
            </div>
            <div class="col-md-2 col-6 d-flex gap-1">
                <button type="submit" class="btn btn-primary   flex-grow-1">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('admin.ip-addresses.index') }}" class="btn btn-outline-secondary  ">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex align-items-center">
        <i class="fas fa-network-wired me-2 text-primary"></i> IP Address Pool
        <span class="badge bg-secondary ms-2">{{ $ipAddresses->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sl.</th>
                        <th>IP Address</th>
                        <th>Subnet Mask</th>
                        <th>Gateway</th>
                        <th>DNS</th>
                        <th>Type</th>
                        <th>VLAN</th>
                        <th>Status</th>
                        <th>Allocated To</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ipAddresses as $i => $ip)
                    <tr>
                        <td class="text-muted">{{ $ipAddresses->firstItem() + $i }}</td>
                        <td><code class="fw-semibold">{{ $ip->ip_address }}</code></td>
                        <td>{{ $ip->subnet_mask ?? '—' }}</td>
                        <td>{{ $ip->gateway ?? '—' }}</td>
                        <td class="small">
                            {{ $ip->dns_primary ?? '—' }}
                            @if($ip->dns_secondary)<br><span class="text-muted">{{ $ip->dns_secondary }}</span>@endif
                        </td>
                        <td><span class="badge bg-info text-dark">{{ $ip->network_type }}</span></td>
                        <td>{{ $ip->vlan ?? '—' }}</td>
                        <td>{!! $ip->status_badge !!}</td>
                        <td>
                            @if($ip->activeAllocation)
                                <a href="{{ route('admin.ip-addresses.allocations.index', ['search' => $ip->ip_address]) }}" class="text-decoration-none small">
                                    {{ $ip->activeAllocation->user->name }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                {{-- Edit --}}
                                <button type="button" class="btn btn-outline-primary" title="Edit"
                                    data-bs-toggle="modal" data-bs-target="#editIpModal"
                                    data-id="{{ $ip->id }}"
                                    data-ip="{{ $ip->ip_address }}"
                                    data-subnet="{{ $ip->subnet_mask }}"
                                    data-gateway="{{ $ip->gateway }}"
                                    data-dns1="{{ $ip->dns_primary }}"
                                    data-dns2="{{ $ip->dns_secondary }}"
                                    data-type="{{ $ip->network_type }}"
                                    data-vlan="{{ $ip->vlan }}"
                                    data-desc="{{ $ip->description }}"
                                    data-status="{{ $ip->status }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                {{-- History --}}
                                <a href="{{ route('admin.ip-addresses.allocations.history', $ip->id) }}"
                                   class="btn btn-outline-info" title="Allocation History">
                                    <i class="fas fa-history"></i>
                                </a>
                                {{-- Delete --}}
                                @if($ip->status !== 'allocated')
                                <form method="POST" action="{{ route('admin.ip-addresses.destroy', $ip->id) }}"
                                      onsubmit="return confirm('Delete IP {{ $ip->ip_address }}?')">
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
                    <tr><td colspan="10" class="text-center text-muted py-4">No IP addresses found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($ipAddresses->hasPages())
    <div class="card-footer">
        {{ $ipAddresses->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- ════════════════════════════════════════════════════
     MODALS
     ════════════════════════════════════════════════════ --}}

{{-- Add IP Modal --}}
<div class="modal fade" id="addIpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.ip-addresses.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add IP Address</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('admin.ip-addresses._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit IP Modal --}}
<div class="modal fade" id="editIpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editIpForm" action="">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit IP Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('admin.ip-addresses._form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.ip-addresses.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title"><i class="fas fa-file-upload me-2"></i>Import IP Addresses</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small mb-3">
                        <strong>CSV Column Order:</strong><br>
                        ip_address, subnet_mask, gateway, dns_primary, dns_secondary, network_type, vlan, description, status
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">CSV File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept=".csv,.txt" required>
                    </div>
                    <a href="#" id="downloadSample" class="small text-decoration-none">
                        <i class="fas fa-download me-1"></i>Download sample CSV
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i>Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Populate edit modal
document.getElementById('editIpModal').addEventListener('show.bs.modal', function (e) {
    const btn    = e.relatedTarget;
    const form   = document.getElementById('editIpForm');
    form.action  = `/admin/ip-addresses/${btn.dataset.id}`;

    form.querySelector('[name=ip_address]').value   = btn.dataset.ip      ?? '';
    form.querySelector('[name=subnet_mask]').value  = btn.dataset.subnet  ?? '';
    form.querySelector('[name=gateway]').value      = btn.dataset.gateway ?? '';
    form.querySelector('[name=dns_primary]').value  = btn.dataset.dns1    ?? '';
    form.querySelector('[name=dns_secondary]').value= btn.dataset.dns2    ?? '';
    form.querySelector('[name=network_type]').value = btn.dataset.type    ?? 'LAN';
    form.querySelector('[name=vlan]').value         = btn.dataset.vlan    ?? '';
    form.querySelector('[name=description]').value  = btn.dataset.desc    ?? '';
    form.querySelector('[name=status]').value       = btn.dataset.status  ?? 'available';
});

// Sample CSV download
document.getElementById('downloadSample').addEventListener('click', function (e) {
    e.preventDefault();
    const csv  = 'ip_address,subnet_mask,gateway,dns_primary,dns_secondary,network_type,vlan,description,status\n'
               + '192.168.1.10,255.255.255.0,192.168.1.1,8.8.8.8,8.8.4.4,LAN,VLAN10,Office PC,available\n'
               + '192.168.1.11,255.255.255.0,192.168.1.1,8.8.8.8,,LAN,,Server,reserved\n';
    const a    = document.createElement('a');
    a.href     = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    a.download = 'ip_import_sample.csv';
    a.click();
});
</script>
@endpush
