{{-- resources/views/admin/vendors/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Vendor')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.vendors.index') }}">Vendors</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Vendor')
@section('page-subtitle', 'Update vendor information')

@section('page-actions')
    <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-outline-info">
        <i class="fas fa-eye"></i>
        View
    </a>

    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" class="needs-validation" novalidate>

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Vendor Information --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-building text-primary"></i>
                        Vendor Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">
                                    Vendor Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $vendor->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Vendor Code
                                </label>

                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $vendor->code) }}">

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Contact Person
                                </label>

                                <input type="text" name="contact_person" class="form-control"
                                    value="{{ old('contact_person', $vendor->contact_person) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Mobile
                                </label>

                                <input type="text" name="mobile" class="form-control"
                                    value="{{ old('mobile', $vendor->mobile) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">
                                    Phone
                                </label>

                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $vendor->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $vendor->email) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Website
                                </label>

                                <input type="url" name="website" class="form-control"
                                    value="{{ old('website', $vendor->website) }}">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Address --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        Address Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label">Address</label>

                                <textarea name="address" rows="3" class="form-control">{{ old('address', $vendor->address) }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>

                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $vendor->city) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State</label>

                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $vendor->state) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>

                                <input type="text" name="pincode" class="form-control"
                                    value="{{ old('pincode', $vendor->pincode) }}">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Tax & Bank --}}
                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-university text-primary"></i>
                        Tax & Banking Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">GSTIN</label>

                                <input type="text" name="gstin" class="form-control"
                                    value="{{ old('gstin', $vendor->gstin) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">PAN</label>

                                <input type="text" name="pan" class="form-control"
                                    value="{{ old('pan', $vendor->pan) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Bank Name</label>

                                <input type="text" name="bank_name" class="form-control"
                                    value="{{ old('bank_name', $vendor->bank_name) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Account Number</label>

                                <input type="text" name="bank_account_no" class="form-control"
                                    value="{{ old('bank_account_no', $vendor->bank_account_no) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">IFSC Code</label>

                                <input type="text" name="bank_ifsc" class="form-control"
                                    value="{{ old('bank_ifsc', $vendor->bank_ifsc) }}">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- AMC --}}
                <div class="card">

                    <div class="card-header">
                        <i class="fas fa-tools text-primary"></i>
                        AMC Information
                    </div>

                    <div class="card-body">

                        <div class="form-check mb-3">

                            <input type="checkbox" class="form-check-input" name="provides_amc" id="provides_amc"
                                value="1" {{ old('provides_amc', $vendor->provides_amc) ? 'checked' : '' }}>

                            <label class="form-check-label" for="provides_amc">
                                Vendor Provides AMC Services
                            </label>

                        </div>

                        <label class="form-label">
                            AMC Terms
                        </label>

                        <textarea name="amc_terms" rows="4" class="form-control">{{ old('amc_terms', $vendor->amc_terms) }}</textarea>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                <div class="card mb-3">

                    <div class="card-header">
                        <i class="fas fa-cog text-primary"></i>
                        Status & Notes
                    </div>

                    <div class="card-body">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select mb-3">

                            <option value="active" {{ old('status', $vendor->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive" {{ old('status', $vendor->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        <label class="form-label">
                            Notes
                        </label>

                        <textarea name="notes" rows="6" class="form-control">{{ old('notes', $vendor->notes) }}</textarea>

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
                                <td>{{ $vendor->created_at?->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>{{ $vendor->updated_at?->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <th>Assets</th>
                                <td>{{ $vendor->assets()->count() }}</td>
                            </tr>

                            <tr>
                                <th>Maintenance</th>
                                <td>{{ $vendor->maintenances()->count() }}</td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            {{-- Submit --}}
            <div class="col-12">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Vendor
                </button>

                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>

            </div>

        </div>

    </form>

@endsection
