{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Asset Categories')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Categories</span>
@endsection

@section('page-title', 'Asset Categories')
@section('page-subtitle', 'Manage asset categories and sub-categories')

@section('page-actions')
@can('categories.create')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Category
</a>
@endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tags me-2 text-primary"></i>All Categories</span>
        <span class="badge bg-secondary">{{ $categories->total() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Sub-Categories</th>
                        <th>Depreciation</th>
                        <th>Assets</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $i => $category)
                    <tr>
                        <td class="text-muted text-sm">{{ $categories->firstItem() + $i }}</td>
                        <td>
                            <div style="width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;"
                                 class="bg-primary bg-opacity-10 text-primary">
                                <i class="{{ $category->icon ?? 'fas fa-boxes-stacked' }}"></i>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.show', $category) }}"
                               class="fw-600 text-dark text-decoration-none">
                                {{ $category->name }}
                            </a>
                            @if($category->description)
                            <div class="text-muted text-xs">{{ Str::limit($category->description, 40) }}</div>
                            @endif
                        </td>
                        <td><code class="text-primary">{{ $category->code }}</code></td>
                        <td>
                            @php $subs = $category->sub_categories ?? []; @endphp
                            @if(count($subs))
                            <span class="badge bg-info bg-opacity-10 text-info">
                                {{ count($subs) }} sub-categories
                            </span>
                            @else
                            <span class="text-muted text-xs">None</span>
                            @endif
                        </td>
                        <td>
                            @if($category->depreciation_rate)
                            <span class="fw-600">{{ $category->depreciation_rate }}%</span>
                            <span class="text-muted text-xs">p.a.</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.assets.index', ['category_id' => $category->id]) }}"
                               class="badge bg-primary bg-opacity-10 text-primary text-decoration-none">
                                {{ $category->assets_count }}
                            </a>
                        </td>
                        <td>
                            <span class="status-pill text-{{ $category->status === 'active' ? 'success' : 'danger' }}
                                  bg-{{ $category->status === 'active' ? 'success' : 'danger' }} bg-opacity-10">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.categories.show', $category) }}"
                                   class="btn btn-icon btn-sm btn-outline-info"
                                   data-bs-toggle="tooltip" title="View">
                                    <i class="fas fa-eye fa-xs"></i>
                                </a>
                                @can('categories.edit')
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-icon btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-pen fa-xs"></i>
                                </a>
                                @endcan
                                @can('categories.delete')
                                <form action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-outline-danger"
                                            data-confirm="Delete category '{{ $category->name }}'?"
                                            data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-2">No categories found</p>
                            @can('categories.create')
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Add First Category
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
