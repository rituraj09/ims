@extends('layouts.app')

@section('title', 'Add Department')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.departments.index') }}">Departments</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Create</span>
@endsection

@section('page-title', 'Add Department')
@section('page-subtitle', 'Create a new department')

@section('page-actions')
    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.departments.store') }}" method="POST">
        @csrf

        <div class="row g-3">

            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-building text-primary"></i>
                        Department Information
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">Department Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Parent Department</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">None</option>

                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('parent_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Department Head</label>

                                <select name="head_user_id" class="form-select select2">
                                    <option value="">Select Employee</option>

                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('head_user_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        Location Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-3">
                                <label class="form-label">Building</label>
                                <input type="text" name="building" class="form-control" value="{{ old('building') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Block</label>
                                <input type="text" name="block" class="form-control" value="{{ old('block') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Floor</label>
                                <input type="text" name="floor" class="form-control" value="{{ old('floor') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Room No</label>
                                <input type="text" name="room_no" class="form-control" value="{{ old('room_no') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="city" class="form-control" placeholder="City"
                                    value="{{ old('city') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="state" class="form-control" placeholder="State"
                                    value="{{ old('state') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="pincode" class="form-control" placeholder="Pincode"
                                    value="{{ old('pincode') }}">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Contact --}}
                <div class="card">
                    <div class="card-header">
                        Contact Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">
                    <div class="card-header">
                        Settings
                    </div>

                    <div class="card-body">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select mb-3">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <label class="form-label">Notes</label>

                        <textarea name="notes" rows="6" class="form-control">{{ old('notes') }}</textarea>

                    </div>
                </div>

            </div>

            <div class="col-12">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Department
                </button>
            </div>

        </div>

    </form>

@endsection
