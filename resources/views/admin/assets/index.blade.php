{{-- resources/views/admin/assets/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Assets')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">Assets</span>
@endsection

@section('page-title', 'Asset Inventory')
@section('page-subtitle', 'Manage all government assets')

@section('page-actions')
    @can('assets.create')
        <a href="{{ route('admin.assets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Asset
        </a>
    @endcan
    <a href="{{ route('admin.reports.assets') }}" class="btn btn-outline-secondary">
        <i class="fas fa-download"></i> <span class="d-none d-sm-inline">Export</span>
    </a>
@endsection

@section('content')

    {{-- Status Filter Pills --}}
    <div class="d-flex gap-2 flex-wrap mb-3">
        @php
            $statuses = [
                'all' => ['label' => 'All', 'color' => 'secondary'],
                'available' => ['label' => 'Available', 'color' => 'success'],
                'in_use' => ['label' => 'In Use', 'color' => 'primary'],
                'under_maintenance' => ['label' => 'Maintenance', 'color' => 'warning'],
                'disposed' => ['label' => 'Disposed', 'color' => 'danger'],
                'lost' => ['label' => 'Lost', 'color' => 'dark'],
            ];
            $currentStatus = request('status', 'all');
        @endphp
        @foreach ($statuses as $key => $s)
            <a href="{{ route('admin.assets.index', array_merge(request()->except('status', 'page'), $key !== 'all' ? ['status' => $key] : [])) }}"
                class="btn btn-sm {{ $currentStatus === $key || ($key === 'all' && !request('status')) ? 'btn-' . $s['color'] : 'btn-outline-' . $s['color'] }}">
                {{ $s['label'] }}
                @if (isset($statusCounts[$key]))
                    <span class="ms-1 badge bg-white text-{{ $s['color'] }}">{{ $statusCounts[$key] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('admin.assets.index') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">

                <div class="row g-2 align-items-center">

                    {{-- Search --}}
                    <div class="col-md-4 col-12">
                        <div class="input-group">
                            <span class="input-group-text"
                                style="border: 1.5px solid var(--border);
                                     border-right: none;
                                     border-radius: 8px 0 0 8px;
                                     background: #fff;
                                     padding: 0 10px;
                                     display: flex;
                                     align-items: center;">
                                <i class="fas fa-search" style="color: var(--text-muted); font-size: 12px;"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search tag, name, serial..."
                                style="border-left: none;
                                      border-radius: 0 8px 8px 0;">
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-3 col-6">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-3 col-6">
                        <select name="department_id" class="form-select">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-2 col-12">
                        <div style="display: flex; gap: 6px;">

                            {{-- Search Button --}}
                            <button type="submit" class="btn btn-primary"
                                style="flex: 1;
                                       justify-content: center;
                                       padding: 8px 12px;
                                       white-space: nowrap;">
                                <i class="fas fa-search"></i>
                                Search
                            </button>

                            {{-- Clear Button --}}
                            @if (request()->hasAny(['search', 'category_id', 'department_id']))
                                <a href="{{ route('admin.assets.index', ['status' => request('status')]) }}"
                                    class="btn btn-outline-secondary" title="Clear Filters"
                                    style="padding: 8px 10px;
                                      justify-content: center;
                                      flex-shrink: 0;">
                                    <i class="fas fa-times"></i>
                                </a>
                            @else
                                <button type="button" class="btn btn-outline-secondary" disabled title="No filters applied"
                                    style="padding: 8px 10px;
                                           justify-content: center;
                                           flex-shrink: 0;
                                           opacity: 0.45;
                                           cursor: not-allowed;">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    {{-- Assets Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-boxes-stacked me-2 text-primary"></i>Assets</span>
            <span class="badge bg-secondary">{{ $assets->total() }} records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Asset Tag</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Make/Model</th>
                            <th>Status</th>
                            <th>Condition</th>
                            <th>Current location</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.assets.show', $asset) }}"
                                        class="fw-600 text-primary text-decoration-none">
                                        {{ $asset->asset_tag }}
                                    </a>
                                    @if ($asset->serial_no)
                                        <div class="text-xs text-muted">S/N: {{ $asset->serial_no }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-600 text-sm">{{ Str::limit($asset->name, 30) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $asset->category?->name ?? '—' }}
                                    </span>
                                    @if ($asset->sub_category_name)
                                        <div class="text-xs text-muted">{{ $asset->sub_category_name }}</div>
                                    @endif
                                </td>
                                <td class="text-sm">
                                    {{ $asset->make_brand ?? '—' }}
                                    @if ($asset->model)
                                        <div class="text-xs text-muted">{{ $asset->model }}</div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'available' => 'success',
                                            'in_use' => 'primary',
                                            'under_maintenance' => 'warning',
                                            'disposed' => 'danger',
                                            'lost' => 'dark',
                                            'transferred' => 'info',
                                        ];
                                        $sc = $statusColors[$asset->status] ?? 'secondary';
                                    @endphp
                                    <span
                                        class="status-pill text-{{ $sc }} bg-{{ $sc }} bg-opacity-10">
                                        {{ $asset->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $condColors = [
                                            'new' => 'success',
                                            'good' => 'info',
                                            'fair' => 'warning',
                                            'poor' => 'danger',
                                            'condemned' => 'dark',
                                        ];
                                        $cc = $condColors[$asset->condition] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $cc }} bg-opacity-10 text-{{ $cc }}">
                                        {{ ucfirst($asset->condition) }}
                                    </span>
                                </td>
                                <td class="text-sm">
                                    @if ($asset->assigned_to_type === 'department')
                                        <i class="fas fa-building text-primary me-1"></i>
                                        {{ Str::limit($asset->assignedDepartment?->name ?? '—', 20) }}
                                    @elseif($asset->assigned_to_type === 'employee')
                                        <i class="fas fa-user text-success me-1"></i>
                                        {{ Str::limit($asset->assignedEmployee?->name ?? '—', 20) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.assets.show', $asset) }}"
                                            class="btn btn-icon btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                            title="View">
                                            <i class="fas fa-eye fa-xs"></i>
                                        </a>
                                        @can('edit', $asset)
                                            <a href="{{ route('admin.assets.edit', $asset) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </a>
                                        @endcan
                                        @can('assign', $asset)
                                            @if ($asset->status === 'available')
                                                <a href="{{ route('admin.assets.assign', $asset) }}"
                                                    class="btn btn-icon btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                                    title="Assign">
                                                    <i class="fas fa-share fa-xs"></i>
                                                </a>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="fas fa-boxes-stacked fa-3x text-muted opacity-25 mb-3 d-block"></i>
                                    <p class="text-muted">No assets found</p>
                                    @can('assets.create')
                                        <a href="{{ route('admin.assets.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Add First Asset
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($assets->hasPages())
            <div class="card-footer">
                {{ $assets->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
