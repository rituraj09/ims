```blade
{{-- resources/views/admin/vendors/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add Vendor')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.vendors.index') }}">Vendors</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Create</span>
@endsection

@section('page-title', 'Add Vendor')
@section('page-subtitle', 'Create a new vendor / supplier')

@section('page-actions')
    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.vendors.store') }}" method="POST">
        @csrf

        <div class="row g-3">

            <div class="col-lg-8">

                <div class="card">
                    <div class="card-header">
                        Vendor Information
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Vendor Code</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person" class="form-control"
                                    value="{{ old('contact_person') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Website</label>
                                <input type="url" name="website" class="form-control" value="{{ old('website') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">GSTIN</label>
                                <input type="text" name="gstin" class="form-control" value="{{ old('gstin') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">PAN</label>
                                <input type="text" name="pan" class="form-control" value="{{ old('pan') }}">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Bank Details</div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-4">
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="bank_account_no" class="form-control"
                                    placeholder="Account No">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="bank_ifsc" class="form-control" placeholder="IFSC Code">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">AMC Information</div>

                    <div class="card-body">

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="provides_amc" value="1">
                            <label class="form-check-label">
                                Vendor provides AMC Services
                            </label>
                        </div>

                        <textarea name="amc_terms" rows="4" class="form-control" placeholder="AMC Terms"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">
                    <div class="card-header">Status & Notes</div>

                    <div class="card-body">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select mb-3">

                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>

                        </select>

                        <label class="form-label">Notes</label>

                        <textarea name="notes" rows="6" class="form-control"></textarea>

                    </div>
                </div>

            </div>

            <div class="col-12">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Vendor
                </button>
            </div>

        </div>
    </form>
@endsection
```
