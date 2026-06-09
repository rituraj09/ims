{{-- resources/views/admin/ip-allocation/history.blade.php --}}
@extends('layouts.app')
@section('title', 'IP Allocation History')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.ip-addresses.index') }}">IP Address Pool</a>
    <span class="bc-sep">/</span>
    {{-- FIX 1: was admin.ip-allocation.index → admin.ip-addresses.allocations.index --}}
    <a href="{{ route('admin.ip-addresses.allocations.index') }}">Allocation</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">History</span>
@endsection

@section('page-title', 'IP Allocation History')
@section('page-subtitle', 'Full history for ' . $ipAddress->ip_address)

@section('page-actions')
    <button type="button" class="btn btn-outline-danger" onclick="window.print()">
        <i class="fas fa-print me-1"></i> Print
    </button>
    {{-- FIX 2: was admin.ip-allocation.index → admin.ip-addresses.allocations.index --}}
    <a href="{{ route('admin.ip-addresses.allocations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
@endsection

@section('content')

{{-- IP Summary Card --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="small text-muted">IP Address</div>
                <div class="fw-bold fs-5">
                    <code>{{ $ipAddress->ip_address }}</code>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small text-muted">Subnet / Gateway</div>
                <div>{{ $ipAddress->subnet_mask ?? '—' }} / {{ $ipAddress->gateway ?? '—' }}</div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small text-muted">Network Type / VLAN</div>
                <div>
                    <span class="badge bg-info text-dark">{{ $ipAddress->network_type }}</span>
                    {{ $ipAddress->vlan ? '/ ' . $ipAddress->vlan : '' }}
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small text-muted">Current Status</div>
                <div>{!! $ipAddress->status_badge !!}</div>
            </div>
            @if($ipAddress->description)
            <div class="col-12">
                <div class="small text-muted">Description</div>
                <div>{{ $ipAddress->description }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- History Timeline Table --}}
<div class="card">
    <div class="card-header d-flex align-items-center">
        <i class="fas fa-timeline me-2 text-primary"></i>
        Allocation History
        {{-- FIX 3: guard total() in case simplePaginate is used --}}
        <span class="badge bg-secondary ms-2">
            {{ method_exists($allocations, 'total') ? $allocations->total() : $allocations->count() }}
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sl.</th>
                        <th>Employee</th>
                        <th>Ethernet MAC</th>
                        <th>WiFi MAC</th>
                        <th>Device</th>
                        <th>Date Allocated</th>
                        <th>Date Released</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Allocated By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allocations as $i => $a)

                    {{-- Main Row --}}
                    <tr class="{{ $a->status === 'active' ? 'table-success' : '' }}">
                        <td class="text-muted">
                            {{-- FIX 4: guard firstItem() for simplePaginate --}}
                            {{ method_exists($allocations, 'firstItem') ? $allocations->firstItem() + $i : $loop->iteration }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $a->user->name }}</div>
                            <div class="small text-muted">{{ $a->user->email }}</div>
                        </td>
                        <td> {{ $a->asset?->networkDetail?->ethernet_mac ?? '—' }}</td>
                        <td> {{ $a->asset?->networkDetail?->wifi_mac ?? '—' }}</td>
                        <td>
                           {{ $a->asset?->name }}
                            @if($a->asset?->asset_tag)
                                <span class="badge bg-light text-dark border ms-1">
                                    {{ $a->asset?->asset_tag }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $a->date_allocated?->format('d M Y') }}</td>
                        <td>{{ $a->date_released?->format('d M Y') ?? '—' }}</td>
                        <td class="small text-muted">
                            @if($a->date_allocated)
                                @php
                                    $end  = $a->date_released ?? now();
                                    $days = $a->date_allocated->diffInDays($end);
                                @endphp
                                {{ $days }} day{{ $days != 1 ? 's' : '' }}
                            @else
                                —
                            @endif
                        </td>
                        <td>{!! $a->status_badge !!}</td>
                        <td class="small">{{ $a->allocatedBy?->name ?? '—' }}</td>
                    </tr>

                    {{-- Notes Row (only if notes exist) --}}
                    @if($a->notes)
                    <tr class="{{ $a->status === 'active' ? 'table-success' : '' }}">
                        <td></td>
                        <td colspan="10" class="small text-muted fst-italic pb-2">
                            <i class="fas fa-comment-alt me-1"></i>{{ $a->notes }}
                        </td>
                    </tr>
                    @endif

                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            No allocation history for this IP.
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

@endsection
