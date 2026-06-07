{{-- resources/views/admin/employees/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Employees')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">Employees</span>
@endsection

@section('page-title', 'Employees')
@section('page-subtitle', 'Manage employees and system users')

@section('page-actions')
    @can('employees.create')
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Employee
        </a>
    @endcan
@endsection

@section('content')

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('admin.employees.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4 col-6">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm" placeholder="Search name, email, ID...">
                </div>
                <div class="col-md-3 col-6">
                    <select name="department_id" class="form-select form-select-sm">
                        <option value="">All Departments</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1 col-6 d-flex gap-1">
                    <button type="submit" class="btn btn-primary"
                        style="flex: 1;
                                       justify-content: center;
                                       padding: 8px 12px;
                                       white-space: nowrap;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary" title="Clear Filters"
                        style="padding: 8px 10px;
                                      justify-content: center;
                                      flex-shrink: 0;">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-2 text-primary"></i>Employees</span>
            <span class="badge bg-secondary">{{ $employees->total() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>ID</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $i => $emp)
                            <tr>
                                <td class="text-muted text-sm">{{ $employees->firstItem() + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->name) }}&background=3b82f6&color=fff&size=40"
                                            alt="{{ $emp->name }}"
                                            style="width:34px;height:34px;border-radius:50%;object-fit:cover;">
                                        <div>
                                            <a href="{{ route('admin.employees.show', $emp) }}"
                                                class="fw-600 text-dark text-decoration-none">
                                                {{ $emp->name }}
                                            </a>
                                            @if ($emp->email)
                                                <div class="text-xs text-muted">{{ $emp->email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm">
                                    @if ($emp->employee_id)
                                        <code class="text-primary">{{ $emp->employee_id }}</code>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-sm">{{ $emp->designation?->name ?? '—' }}</td>
                                <td class="text-sm">{{ $emp->department?->name ?? '—' }}</td>
                                <td>
                                    @if ($emp->role)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $emp->role->display_name }}
                                        </span>
                                    @else
                                        <span class="text-muted text-sm">No Access</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="status-pill text-{{ $emp->status === 'active' ? 'success' : 'danger' }} bg-{{ $emp->status === 'active' ? 'success' : 'danger' }} bg-opacity-10">
                                        {{ ucfirst($emp->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.employees.show', $emp) }}"
                                            class="btn btn-icon btn-sm btn-outline-info">
                                            <i class="fas fa-eye fa-xs"></i>
                                        </a>
                                        @can('employees.edit')
                                            <a href="{{ route('admin.employees.edit', $emp) }}"
                                                class="btn btn-icon btn-sm btn-outline-primary">
                                                <i class="fas fa-pen fa-xs"></i>
                                            </a>
                                        @endcan
                                        @can('employees.delete')
                                            <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger"
                                                    data-confirm="Delete '{{ $emp->name }}'?">
                                                    <i class="fas fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-3x opacity-25 d-block mb-3"></i>
                                    No employees found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($employees->hasPages())
            <div class="card-footer">{{ $employees->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
