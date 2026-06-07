{{-- resources/views/admin/designations/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Designation')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.designations.index') }}">Designations</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Designation')
@section('page-subtitle', 'Update designation details')

@section('page-actions')
    <a href="{{ route('admin.designations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.designations.update', $designation) }}" method="POST" class="needs-validation" novalidate>

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-lg-8">

                <div class="card">

                    <div class="card-header">
                        <i class="fas fa-id-badge text-primary"></i>
                        Designation Details
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Designation Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $designation->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Slug
                                </label>

                                <input type="text" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $designation->slug) }}">

                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Department Category
                                </label>

                                <input type="text" name="department_category" class="form-control"
                                    value="{{ old('department_category', $designation->department_category) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Sort Order
                                </label>

                                <input type="number" min="0" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $designation->sort_order) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status" class="form-select">

                                    <option value="active"
                                        {{ old('status', $designation->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        {{ old('status', $designation->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-info"></i>
                        Information
                    </div>

                    <div class="card-body">

                        <table class="table table-sm mb-0">

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($designation->status == 'active')
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
                                <th>Employees</th>
                                <td>{{ $designation->users()->count() }}</td>
                            </tr>

                            <tr>
                                <th>Created</th>
                                <td>
                                    {{ $designation->created_at?->format('d M Y') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>
                                    {{ $designation->updated_at?->format('d M Y') }}
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>

            </div>

            <div class="col-12 mt-3">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Designation
                </button>

                <a href="{{ route('admin.designations.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>

            </div>

        </div>

    </form>

@endsection
