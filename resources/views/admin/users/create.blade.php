{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Add User')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.users.index') }}">Users</a>
<span class="bc-sep">/</span>
<span class="bc-current">Add User</span>
@endsection

@section('page-title', 'Add New User')
@section('page-subtitle', 'Create a new system user account')

@section('page-actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back
</a>
@endsection

@section('content')
<form action="{{ route('admin.users.store') }}" method="POST"
      class="needs-validation" novalidate>
@csrf
<div class="row g-3">
<div class="col-lg-8">

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user text-primary"></i> Personal Information
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required placeholder="Full name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Employee ID</label>
                    <input type="text" name="employee_id"
                           class="form-control @error('employee_id') is-invalid @enderror"
                           value="{{ old('employee_id') }}" placeholder="EMP-001">
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required placeholder="email@example.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" class="form-control"
                           value="{{ old('mobile') }}" placeholder="10-digit mobile">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other"  {{ old('gender') === 'other'  ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Designation</label>
                    <select name="designation_id" class="form-select select2">
                        <option value="">-- Select Designation --</option>
                        @foreach($designations as $desig)
                        <option value="{{ $desig->id }}" {{ old('designation_id') == $desig->id ? 'selected' : '' }}>
                            {{ $desig->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select select2">
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Joining Date</label>
                    <input type="text" name="joining_date"
                           class="form-control datepicker"
                           value="{{ old('joining_date') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-lock text-warning"></i> Login Credentials
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required minlength="8" placeholder="Min. 8 characters">
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePwd('password','eyeIcon1')">
                            <i class="fas fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" required placeholder="Repeat password">
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePwd('password_confirmation','eyeIcon2')">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="col-lg-4">

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-shield text-primary"></i> Access Control
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role_id" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }}
                    </option>
                    @endforeach
                </select>
                @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2">
                <i class="fas fa-save"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                Cancel
            </a>
        </div>
    </div>

</div>
</div>
</form>
@endsection

@push('scripts')
<script>
function togglePwd(id, iconId) {
    const input = document.getElementById(id);
    const icon  = document.getElementById(iconId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
</script>
@endpush
