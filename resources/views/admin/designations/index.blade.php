{{-- resources/views/admin/designations/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Designations')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Designations</span>
@endsection

@section('page-title', 'Designations')
@section('page-subtitle', 'Manage employee designations')

@section('page-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#addDesignationModal">
    <i class="fas fa-plus"></i> Add Designation
</button>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-id-badge me-2 text-primary"></i>All Designations
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Sort Order</th>
                        <th>Employees</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designations as $i => $desig)
                    <tr>
                        <td class="text-muted text-xs">{{ $designations->firstItem() + $i }}</td>
                        <td class="fw-600">{{ $desig->name }}</td>
                        <td><code class="text-primary text-xs">{{ $desig->slug }}</code></td>
                        <td class="text-sm text-muted">{{ $desig->department_category ?? '—' }}</td>
                        <td class="text-sm text-center">{{ $desig->sort_order }}</td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info">
                                {{ $desig->users_count }}
                            </span>
                        </td>
                        <td>
                            <span class="status-pill text-{{ $desig->status === 'active' ? 'success' : 'danger' }} bg-{{ $desig->status === 'active' ? 'success' : 'danger' }} bg-opacity-10">
                                {{ ucfirst($desig->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.designations.edit', $desig) }}"
                                   class="btn btn-icon btn-sm btn-outline-primary">
                                    <i class="fas fa-pen fa-xs"></i>
                                </a>
                                <form action="{{ route('admin.designations.destroy', $desig) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-outline-danger"
                                            data-confirm="Delete '{{ $desig->name }}'?">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-id-badge fa-3x opacity-25 d-block mb-3"></i>
                            No designations found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($designations->hasPages())
    <div class="card-footer">{{ $designations->links() }}</div>
    @endif
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addDesignationModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.designations.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-700">
                    <i class="fas fa-plus me-2 text-primary"></i>Add Designation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               required placeholder="e.g. Section Officer">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <input type="text" name="department_category" class="form-control"
                               placeholder="e.g. Gazetted, Non-Gazetted">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
