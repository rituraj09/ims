{{-- resources/views/admin/departments/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Departments')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Departments</span>
@endsection

@section('page-title', 'Departments')
@section('page-subtitle', 'Manage office departments and branches')

@section('page-actions')
@can('departments.create')
<a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add Department
</a>
@endcan
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-building me-2 text-primary"></i>All Departments</span>
        <span class="badge bg-secondary">{{ $departments->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Department</th>
                        <th>Code</th>
                        <th>Head</th>
                        <th>Location</th>
                        <th>Employees</th>
                        <th>Assets</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $i => $dept)
                    <tr>
                        <td class="text-muted text-sm">{{ $departments->firstItem() + $i }}</td>
                        <td>
                            <a href="{{ route('admin.departments.show', $dept) }}"
                               class="fw-600 text-dark text-decoration-none">
                                {{ $dept->name }}
                            </a>
                            @if($dept->children->count())
                            <div class="text-xs text-muted">{{ $dept->children->count() }} sub-departments</div>
                            @endif
                        </td>
                        <td>
                            @if($dept->code)
                            <code class="text-primary">{{ $dept->code }}</code>
                            @else <span class="text-muted">—</span> @endif
                        </td>
                        <td class="text-sm">{{ $dept->head?->name ?? '—' }}</td>
                        <td class="text-sm text-muted">{{ $dept->full_location ?: '—' }}</td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info">
                                {{ $dept->employees_count }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.assets.index', ['department_id' => $dept->id]) }}"
                               class="badge bg-primary bg-opacity-10 text-primary text-decoration-none">
                                {{ $dept->assets_count }}
                            </a>
                        </td>
                        <td>
                            <span class="status-pill text-{{ $dept->status === 'active' ? 'success' : 'danger' }} bg-{{ $dept->status === 'active' ? 'success' : 'danger' }} bg-opacity-10">
                                {{ ucfirst($dept->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.departments.show', $dept) }}"
                                   class="btn btn-icon btn-sm btn-outline-info"
                                   data-bs-toggle="tooltip" title="View">
                                    <i class="fas fa-eye fa-xs"></i>
                                </a>
                                @can('departments.edit')
                                <a href="{{ route('admin.departments.edit', $dept) }}"
                                   class="btn btn-icon btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-pen fa-xs"></i>
                                </a>
                                @endcan
                                @can('departments.delete')
                                <form action="{{ route('admin.departments.destroy', $dept) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-outline-danger"
                                            data-confirm="Delete '{{ $dept->name }}'?"
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
                            <i class="fas fa-building fa-3x text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted">No departments found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($departments->hasPages())
    <div class="card-footer">{{ $departments->links() }}</div>
    @endif
</div>
@endsection
