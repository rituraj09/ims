{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('page-header')
@endsection
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('page-actions')
    @can('assets.create')
    <a href="{{ route('admin.assets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        <span>Add Asset</span>
    </a>
    @endcan
    <a href="{{ route('admin.reports.assets') }}" class="btn btn-outline-secondary">
        <i class="fas fa-chart-bar"></i>
        <span class="d-none d-sm-inline">Reports</span>
    </a>
@endsection

@section('content')

{{-- ═══ STAT CARDS ═══ --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.assets.index') }}" class="stat-card bg-white">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number text-primary">{{ $stats['total_assets'] }}</div>
                <div class="stat-label">Total Assets</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.assets.index', ['status' => 'in_use']) }}"
           class="stat-card bg-white">
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number text-success">{{ $stats['in_use'] }}</div>
                <div class="stat-label">In Use</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.assets.index', ['status' => 'available']) }}"
           class="stat-card bg-white">
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number text-info">{{ $stats['available'] }}</div>
                <div class="stat-label">Available</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.assets.index', ['status' => 'under_maintenance']) }}"
           class="stat-card bg-white">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number text-warning">{{ $stats['under_maintenance'] }}</div>
                <div class="stat-label">Maintenance</div>
            </div>
        </a>
    </div>

</div>

{{-- ═══ ROW 2: Charts + Alerts ═══ --}}
<div class="row g-3 mb-4">

    {{-- Asset by Category Chart --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-pie me-2 text-primary"></i>Assets by Category</span>
                <a href="{{ route('admin.reports.assets') }}"
                   class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" style="max-height:300px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-bell me-2 text-warning"></i>Alerts & Reminders
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">

                    @if($alerts['warranty_expiring'] > 0)
                    <a href="{{ route('admin.reports.warranty') }}"
                       class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3">
                        <div class="alert-icon bg-warning bg-opacity-10 text-warning rounded-2 p-2">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-sm">Warranty Expiring</div>
                            <div class="text-muted" style="font-size:12px;">
                                {{ $alerts['warranty_expiring'] }} assets in 30 days
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark">
                            {{ $alerts['warranty_expiring'] }}
                        </span>
                    </a>
                    @endif

                    @if($alerts['amc_expiring'] > 0)
                    <a href="{{ route('admin.reports.amc') }}"
                       class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3">
                        <div class="alert-icon bg-danger bg-opacity-10 text-danger rounded-2 p-2">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-sm">AMC Expiring</div>
                            <div class="text-muted" style="font-size:12px;">
                                {{ $alerts['amc_expiring'] }} assets in 30 days
                            </div>
                        </div>
                        <span class="badge bg-danger">{{ $alerts['amc_expiring'] }}</span>
                    </a>
                    @endif

                    @if($alerts['pending_maintenance'] > 0)
                    <a href="{{ route('admin.maintenances.index') }}"
                       class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-3 py-3">
                        <div class="alert-icon bg-info bg-opacity-10 text-info rounded-2 p-2">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-sm">Pending Maintenance</div>
                            <div class="text-muted" style="font-size:12px;">
                                {{ $alerts['pending_maintenance'] }} scheduled
                            </div>
                        </div>
                        <span class="badge bg-info">{{ $alerts['pending_maintenance'] }}</span>
                    </a>
                    @endif

                    @if(!$alerts['warranty_expiring'] && !$alerts['amc_expiring'] && !$alerts['pending_maintenance'])
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        No pending alerts
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══ ROW 3: Recent Assets + Financial Summary ═══ --}}
<div class="row g-3">

    {{-- Recent Assets --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2 text-primary"></i>Recently Added Assets</span>
                <a href="{{ route('admin.assets.index') }}"
                   class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAssets as $asset)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.assets.show', $asset) }}"
                                       class="text-primary fw-semibold text-decoration-none">
                                        {{ $asset->asset_tag }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($asset->name, 25) }}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $asset->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge text-{{ $asset->status_color }}
                                          bg-{{ $asset->status_color }} bg-opacity-10">
                                        {{ $asset->status_label }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $asset->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No assets found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Financial Summary --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-rupee-sign me-2 text-success"></i>Financial Summary
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="text-muted small">Total Purchase Value</div>
                    <div class="fw-bold text-primary">
                        ₹{{ number_format($financial['total_purchase_value'], 2) }}
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="text-muted small">Current Book Value</div>
                    <div class="fw-bold text-success">
                        ₹{{ number_format($financial['total_current_value'], 2) }}
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="text-muted small">Total Depreciation</div>
                    <div class="fw-bold text-danger">
                        ₹{{ number_format($financial['total_depreciation'], 2) }}
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3">
                    <div class="text-muted small">Maintenance Cost (This Year)</div>
                    <div class="fw-bold text-warning">
                        ₹{{ number_format($financial['maintenance_cost_ytd'], 2) }}
                    </div>
                </div>

                {{-- Department wise count --}}
                <div class="mt-3">
                    <div class="small fw-semibold text-muted mb-2">Top Departments by Assets</div>
                    @foreach($topDepartments as $dept)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small">{{ $dept->name }}</span>
                            <span class="small fw-semibold">{{ $dept->assets_count }}</span>
                        </div>
                        <div class="progress" style="height:5px;">
                            <div class="progress-bar bg-primary"
                                 style="width:{{ ($dept->assets_count / max($topDepartments->max('assets_count'), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Category Chart
const ctx = document.getElementById('categoryChart');
if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($categoryChart['labels']),
            datasets: [{
                data          : @json($categoryChart['data']),
                backgroundColor: [
                    '#3b82f6','#22c55e','#f59e0b',
                    '#ef4444','#8b5cf6','#06b6d4',
                    '#ec4899','#14b8a6','#f97316',
                ],
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive  : true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels  : { font: { size: 12 }, padding: 15 },
                },
            },
        },
    });
}
</script>
@endpush
