@extends('layouts.app')

@section('title', 'Edit Department')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.departments.index') }}">Departments</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Department')
@section('page-subtitle', 'Update department information')

@section('page-actions')
    <a href="{{ route('admin.departments.show', $department) }}" class="btn btn-outline-info">
        <i class="fas fa-eye"></i> View
    </a>

    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.departments.update', $department) }}" method="POST" class="needs-validation" novalidate>

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Department Information --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-building text-primary"></i>
                        Department Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">
                                    Department Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $department->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Department Code
                                </label>

                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $department->code) }}" style="text-transform: uppercase;">

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Parent Department
                                </label>

                                <select name="parent_id" class="form-select">

                                    <option value="">
                                        None
                                    </option>

                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('parent_id', $department->parent_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Department Head
                                </label>

                                <select name="head_user_id" class="form-select select2">

                                    <option value="">
                                        Select Employee
                                    </option>

                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('head_user_id', $department->head_user_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Location Information --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        Location Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label">Building</label>

                                <input type="text" name="building" class="form-control"
                                    value="{{ old('building', $department->building) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Block</label>

                                <input type="text" name="block" class="form-control"
                                    value="{{ old('block', $department->block) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Floor</label>

                                <input type="text" name="floor" class="form-control"
                                    value="{{ old('floor', $department->floor) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Room No</label>

                                <input type="text" name="room_no" class="form-control"
                                    value="{{ old('room_no', $department->room_no) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Address
                                </label>

                                <textarea name="address" rows="3" class="form-control">{{ old('address', $department->address) }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>

                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $department->city) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State</label>

                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $department->state) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>

                                <input type="text" name="pincode" class="form-control"
                                    value="{{ old('pincode', $department->pincode) }}">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Contact Information --}}
                <div class="card">

                    <div class="card-header">
                        <i class="fas fa-phone text-primary"></i>
                        Contact Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Phone
                                </label>

                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $department->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $department->email) }}">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-cogs text-primary"></i>
                        Settings
                    </div>

                    <div class="card-body">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select mb-3">

                            <option value="active" {{ old('status', $department->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $department->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        <label class="form-label">
                            Notes
                        </label>

                        <textarea name="notes" rows="6" class="form-control">{{ old('notes', $department->notes) }}</textarea>

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        <i class="fas fa-info-circle text-info"></i>
                        Information
                    </div>

                    <div class="card-body">

                        <table class="table table-sm mb-0">

                            <tr>
                                <th>Created</th>
                                <td>{{ $department->created_at?->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>{{ $department->updated_at?->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Employees</th>
                                <td>{{ $department->employees()->count() }}</td>
                            </tr>

                            <tr>
                                <th>Assets</th>
                                <td>{{ $department->assets()->count() }}</td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            {{-- Submit --}}
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Department
                </button>

                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>

            </div>

        </div>

    </form>

@endsection
