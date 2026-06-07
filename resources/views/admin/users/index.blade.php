{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')
@section('title', 'User Management')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Users</span>
@endsection

@section('page-title', 'User Management')
@section('page-subtitle', 'Manage system users and access control')

@section('page-actions')
@can('users.create')
<a href="{{ route('admin.users.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add User
</a>
@endcan
@endsection

@section('content')

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3 col-6">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search name, email...">
            </div>
            <div class="col-md-2 col-6">
                <select name="role_id" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="department_id" class="form-select form-select-sm">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 col-6 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-user-shield me-2 text-primary"></i>System Users</span>
        <span class="badge bg-secondary">{{ $users->total() }} users</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Employee ID</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th width="130">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td class="text-muted text-xs">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->profile_photo_url }}"
                                     alt="{{ $user->name }}"
                                     style="width:34px;height:34px;border-radius:50%;object-fit:cover;">
                                <div>
                                    <div class="fw-600">{{ $user->name }}</div>
                                    <div class="text-xs text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->employee_id)
                            <code class="text-primary">{{ $user->employee_id }}</code>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($user->role)
                            @php
                                $roleColors = [
                                    'super_admin' => 'danger',
                                    'admin'       => 'primary',
                                    'author'      => 'info',
                                    'user'        => 'secondary',
                                ];
                                $rc = $roleColors[$user->role->name] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $rc }} bg-opacity-10 text-{{ $rc }}">
                                {{ $user->role->display_name }}
                            </span>
                            @else
                            <span class="text-muted text-xs">No Role</span>
                            @endif
                        </td>
                        <td class="text-sm">{{ $user->department?->name ?? '—' }}</td>
                        <td class="text-xs text-muted">
                            {{ $user->updated_at->diffForHumans() }}
                        </td>
                        <td>
                            <span class="status-pill
                                text-{{ $user->status === 'active' ? 'success' : 'danger' }}
                                bg-{{ $user->status === 'active' ? 'success' : 'danger' }}
                                bg-opacity-10">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-icon btn-sm btn-outline-info"
                                   data-bs-toggle="tooltip" title="View">
                                    <i class="fas fa-eye fa-xs"></i>
                                </a>
                                @can('users.edit')
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-icon btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-pen fa-xs"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-outline-{{ $user->status === 'active' ? 'warning' : 'success' }}"
                                            data-bs-toggle="tooltip"
                                            title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $user->status === 'active' ? 'ban' : 'check' }} fa-xs"></i>
                                    </button>
                                </form>
                                @endif
                                @endcan
                                @can('users.delete')
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-icon btn-sm btn-outline-danger"
                                            data-confirm="Delete user '{{ $user->name }}'?"
                                            data-bs-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </button>
                                </form>
                                @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-users fa-3x opacity-25 d-block mb-3"></i>
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection
