{{-- resources/views/admin/maintenances/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Maintenance Records')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">Maintenance</span>
@endsection

@section('page-title', 'Asset Maintenance')
@section('page-subtitle', 'Track and manage asset maintenance records')

@section('page-actions')
    @can('maintenance.create')
        <a href="{{ route('admin.maintenances.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Record
        </a>
    @endcan
@endsection

@section('content')

    {{-- Status Summary --}}
    <div class="row g-3 mb-3">
        @php
            $statusCards = [
                'scheduled' => ['Scheduled', 'info', 'fas fa-calendar-alt'],
                'in_progress' => ['In Progress', 'warning', 'fas fa-spinner'],
                'completed' => ['Completed', 'success', 'fas fa-check-circle'],
                'cancelled' => ['Cancelled', 'danger', 'fas fa-times-circle'],
            ];
        @endphp
        @foreach ($statusCards as $status => [$label, $color, $icon])
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.maintenances.index', ['status' => $status]) }}"
                    class="stat-card text-decoration-none">
                    <div class="stat-icon bg-{{ $color }} bg-opacity-10 text-{{ $color }}">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <div class="stat-val text-{{ $color }}">
                            {{ $statusCounts[$status] ?? 0 }}
                        </div>
                        <div class="stat-lbl">{{ $label }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-screwdriver-wrench me-2 text-primary"></i>Maintenance Records</span>
            <div class="d-flex gap-2 align-items-center">
                {{-- Quick filter --}}
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.maintenances.index') }}"
                        class="btn btn-{{ !request('status') ? 'primary' : 'outline-primary' }}">All</a>
                    <a href="{{ route('admin.maintenances.index', ['status' => 'in_progress']) }}"
                        class="btn btn-{{ request('status') === 'in_progress' ? 'warning' : 'outline-warning' }}">Active</a>
                    <a href="{{ route('admin.maintenances.index', ['status' => 'scheduled']) }}"
                        class="btn btn-{{ request('status') === 'scheduled' ? 'info' : 'outline-info' }}">Scheduled</a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asset</th>
                            <th>Type</th>
                            <th>Vendor / Technician</th>
                            <th>Start Date</th>
                            <th>Completion</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $i => $maint)
                            <tr>
                                <td class="text-muted text-xs">{{ $maintenances->firstItem() + $i }}</td>
                                <td>
                                    <a href="{{ route('admin.assets.show', $maint->asset) }}"
                                        class="fw-600 text-primary text-decoration-none">
                                        {{ $maint->asset->asset_tag }}
                                    </a>
                                    <div class="text-xs text-muted">
                                        {{ Str::limit($maint->asset->name, 25) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ ucfirst($maint->maintenance_type) }}
                                    </span>
                                </td>
                                <td class="text-sm">
                                    {{ $maint->vendor?->name ?? ($maint->technician_name ?? '—') }}
                                </td>
                                <td class="text-sm">
                                    {{ $maint->start_date->format('d/m/Y') }}
                                </td>
                                <td class="text-sm">
                                    @if ($maint->completion_date)
                                        {{ $maint->completion_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Pending</span>
                                    @endif
                                </td>
                                <td class="text-sm fw-600">
                                    @if ($maint->maintenance_cost)
                                        ₹{{ number_format($maint->maintenance_cost, 0) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $sc = [
                                            'scheduled' => 'info',
                                            'in_progress' => 'warning',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp
                                    <span
                                        class="status-pill text-{{ $sc[$maint->status] ?? 'secondary' }}
                                  bg-{{ $sc[$maint->status] ?? 'secondary' }} bg-opacity-10">
                                        {{ ucfirst(str_replace('_', ' ', $maint->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.maintenances.show', $maint) }}"
                                            class="btn btn-icon btn-sm btn-outline-info">
                                            <i class="fas fa-eye fa-xs"></i>
                                        </a>
                                        @can('maintenance.edit')
                                            <a href="{{ route('admin.maintenances.edit', $maint) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </a>
                                        @endcan
                                        @can('maintenance.delete')
                                            <form action="{{ route('admin.maintenances.destroy', $maint) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger"
                                                    data-confirm="Delete this maintenance record?">
                                                    <i class="fas fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-screwdriver-wrench fa-3x opacity-25 d-block mb-3"></i>
                                    No maintenance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($maintenances->hasPages())
            <div class="card-footer">{{ $maintenances->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
