```blade
@extends('layouts.app')

@section('title', 'Edit User')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.users.index') }}">Users</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit User')
@section('page-subtitle', 'Update employee account information')

@section('page-actions')
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info">
        <i class="fas fa-eye"></i> View
    </a>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="needs-validation" novalidate>

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-user text-primary"></i>
                        Basic Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Employee ID
                                </label>

                                <input type="text" name="employee_id"
                                    class="form-control @error('employee_id') is-invalid @enderror"
                                    value="{{ old('employee_id', $user->employee_id) }}">

                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>

                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Mobile
                                </label>

                                <input type="text" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $user->mobile) }}">

                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Gender
                                </label>

                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                        Female
                                    </option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Joining Date
                                </label>

                                <input type="date" name="joining_date" class="form-control"
                                    value="{{ old('joining_date', optional($user->joining_date)->format('Y-m-d')) }}">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Role & Organization --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-user-shield text-primary"></i>
                        Role & Assignment
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">
                                    Role <span class="text-danger">*</span>
                                </label>

                                <select name="role_id" class="form-select select2" required>

                                    <option value="">
                                        Select Role
                                    </option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Department
                                </label>

                                <select name="department_id" class="form-select select2">

                                    <option value="">
                                        Select Department
                                    </option>

                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Designation
                                </label>

                                <select name="designation_id" class="form-select select2">

                                    <option value="">
                                        Select Designation
                                    </option>

                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                            {{ old('designation_id', $user->designation_id) == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Profile Card --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-image text-primary"></i>
                        Profile
                    </div>

                    <div class="card-body text-center">

                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle border mb-3" width="100"
                            height="100" alt="{{ $user->name }}">

                        <h6 class="mb-1">
                            {{ $user->name }}
                        </h6>

                        <small class="text-muted">
                            {{ $user->email }}
                        </small>

                    </div>

                </div>

                {{-- Status --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-cog text-primary"></i>
                        Account Status
                    </div>

                    <div class="card-body">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                {{-- Notes --}}
                <div class="card">

                    <div class="card-header">
                        <i class="fas fa-sticky-note text-primary"></i>
                        Notes
                    </div>

                    <div class="card-body">

                        <textarea name="notes" rows="5" class="form-control">{{ old('notes', $user->notes) }}</textarea>

                    </div>

                </div>

            </div>

            {{-- Submit --}}
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update User
                </button>

                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>

            </div>

        </div>

    </form>

@endsection
```
