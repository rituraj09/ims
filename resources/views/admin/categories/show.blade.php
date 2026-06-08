{{-- resources/views/admin/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', $category->name)

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.categories.index') }}">Categories</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $category->name }}</span>
@endsection

@section('page-title', $category->name)

@section('page-subtitle')
    Category Details & Associated Assets
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
         @can('categories.edit')
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
        @endcan
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
@endsection

@section('content')

    <div class="row g-3">

        {{-- Category Information --}}
        <div class="col-lg-4">

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-folder-open text-primary"></i>
                    Category Information
                </div>

                <div class="card-body">

                    <div class="text-center mb-4">

                        <div class="mx-auto mb-3"
                            style="width:72px;height:72px;border-radius:16px;
                         background:#3b82f6;color:#fff;
                         display:flex;align-items:center;
                         justify-content:center;font-size:30px;">

                            <i class="{{ $category->icon ?: 'fas fa-boxes-stacked' }}"></i>

                        </div>

                        <h5 class="mb-1">{{ $category->name }}</h5>

                        <code>{{ $category->code }}</code>
                    </div>

                    <table class="table table-sm align-middle mb-0">

                        <tr>
                            <th width="40%">Status</th>
                            <td>
                                @if ($category->status === 'active')
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Depreciation</th>
                            <td>
                                {{ number_format($category->depreciation_rate ?? 0, 2) }}%
                            </td>
                        </tr>

                        <tr>
                            <th>Assets</th>
                            <td>
                                {{ $category->assets_count ?? $category->assets->count() }}
                            </td>
                        </tr>

                        <tr>
                            <th>Created</th>
                            <td>
                                {{ $category->created_at?->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Updated</th>
                            <td>
                                {{ $category->updated_at?->format('d M Y') }}
                            </td>
                        </tr>

                    </table>

                </div>
            </div>

            {{-- Description --}}
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-align-left text-primary"></i>
                    Description
                </div>

                <div class="card-body">

                    @if ($category->description)
                        {!! nl2br(e($category->description)) !!}
                    @else
                        <span class="text-muted">
                            No description available.
                        </span>
                    @endif

                </div>
            </div>

        </div>

        {{-- Sub Categories + Assets --}}
        <div class="col-lg-8">

            {{-- Sub Categories --}}
            <div class="card mb-3">

                <div class="card-header">
                    <i class="fas fa-sitemap text-primary"></i>
                    Sub Categories
                </div>

                <div class="card-body">

                    @if (!empty($category->sub_categories))

                        <div class="row g-2">

                            @foreach ($category->sub_categories as $sub)
                                <div class="col-md-6">

                                    <div class="border rounded p-3 h-100">

                                        <div class="d-flex justify-content-between">

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $sub['name'] ?? '-' }}
                                                </div>

                                                <code>
                                                    {{ $sub['code'] ?? '-' }}
                                                </code>
                                            </div>

                                            <div>
                                                @if (($sub['status'] ?? 'active') === 'active')
                                                    <span class="badge bg-success">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        @if (!empty($sub['description']))
                                            <div class="small text-muted mt-2">
                                                {{ $sub['description'] }}
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center text-muted py-4">

                            <i class="fas fa-sitemap fa-2x opacity-25 mb-2 d-block"></i>

                            No sub-categories found.

                        </div>

                    @endif

                </div>

            </div>

            {{-- Assets --}}
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <span>
                        <i class="fas fa-boxes text-primary"></i>
                        Assets in this Category
                    </span>

                    <span class="badge bg-primary">
                        {{ $assets->total() }}
                    </span>

                </div>

                <div class="card-body p-0">

                    @if ($assets->count())

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Asset Tag</th>
                                        <th>Name</th>
                                        <th>Vendor</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($assets as $asset)
                                        <tr>

                                            <td>
                                                <code>{{ $asset->asset_tag }}</code>
                                            </td>

                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $asset->name }}
                                                </div>

                                                @if ($asset->brand)
                                                    <small class="text-muted">
                                                        {{ $asset->brand }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $asset->vendor?->name ?? '-' }}
                                            </td>

                                            <td>

                                                @if ($asset->assignedEmployee)
                                                    {{ $asset->assignedEmployee->full_name }}
                                                @elseif($asset->assignedDepartment)
                                                    {{ $asset->assignedDepartment->name }}
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td>

                                                @php
                                                    $statusClass = match ($asset->status) {
                                                        'active' => 'success',
                                                        'assigned' => 'info',
                                                        'maintenance' => 'warning',
                                                        'retired' => 'secondary',
                                                        default => 'dark',
                                                    };
                                                @endphp

                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($asset->status) }}
                                                </span>

                                            </td>

                                            <td>

                                                <a href="{{ route('admin.assets.show', $asset) }}"
                                                    class="btn btn-sm btn-outline-primary">

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                    @else
                        <div class="text-center py-5 text-muted">

                            <i class="fas fa-box-open fa-3x opacity-25 mb-3"></i>

                            <div>No assets available in this category.</div>

                        </div>

                    @endif

                </div>

                @if ($assets->hasPages())
                    <div class="card-footer">
                        {{ $assets->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
