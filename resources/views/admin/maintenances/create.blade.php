@extends('layouts.app')

@section('title', 'Add Maintenance Record')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.maintenances.index') }}">Maintenance</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Create</span>
@endsection

@section('page-title', 'Add Maintenance Record')
@section('page-subtitle', 'Create a new asset maintenance entry')

@section('page-actions')
    <a href="{{ route('admin.maintenances.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.maintenances.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

            {{-- Left Side --}}
            <div class="col-lg-8">

                {{-- Asset Information --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-laptop text-primary"></i> Asset Information
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">
                                Asset <span class="text-danger">*</span>
                            </label>
                            <select name="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required>
                                <option value="">Select Asset</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}" @selected(old('asset_id', $selectedAsset?->id) == $asset->id)>
                                        {{ $asset->asset_tag }} - {{ $asset->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Maintenance Type <span class="text-danger">*</span>
                                </label>
                                <select name="maintenance_type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="preventive">Preventive</option>
                                    <option value="corrective">Corrective</option>
                                    <option value="amc">AMC</option>
                                    <option value="calibration">Calibration</option>
                                    <option value="inspection">Inspection</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reference No.</label>
                                <input type="text" name="reference_no" class="form-control"
                                    value="{{ old('reference_no') }}">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Schedule --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-calendar text-info"></i> Schedule
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Scheduled Date</label>
                                <input type="date" name="scheduled_date" class="form-control"
                                    value="{{ old('scheduled_date') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ old('start_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Completion Date</label>
                                <input type="date" name="completion_date" class="form-control"
                                    value="{{ old('completion_date') }}">
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Vendor / Technician --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-user-cog text-warning"></i> Vendor / Technician
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Vendor</label>
                                <select name="vendor_id" class="form-select">
                                    <option value="">Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Technician Name</label>
                                <input type="text" name="technician_name" class="form-control"
                                    value="{{ old('technician_name') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Technician Contact</label>
                                <input type="text" name="technician_contact" class="form-control"
                                    value="{{ old('technician_contact') }}">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Work Details --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-tools text-danger"></i> Maintenance Details
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Issue Description</label>
                            <textarea name="issue_description" rows="3" class="form-control">{{ old('issue_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Work Done</label>
                            <textarea name="work_done" rows="3" class="form-control">{{ old('work_done') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Parts Replaced</label>
                            <textarea name="parts_replaced" rows="2" class="form-control">{{ old('parts_replaced') }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Right Side --}}
            <div class="col-lg-4">

                {{-- Status --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-flag text-success"></i> Status
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select name="status" class="form-select" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Condition After Maintenance</label>

                            <select name="condition_after" class="form-select">
                                <option value="">Select Condition</option>
                                <option value="new">New</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                                <option value="condemned">Condemned</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Cost & Invoice --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar text-primary"></i> Cost & Invoice
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Maintenance Cost</label>
                            <input type="number" step="0.01" min="0" name="maintenance_cost"
                                class="form-control" value="{{ old('maintenance_cost') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Invoice No.</label>
                            <input type="text" name="invoice_no" class="form-control"
                                value="{{ old('invoice_no') }}">
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Invoice File</label>
                            <input type="file" name="invoice_file" class="form-control">
                        </div>

                    </div>
                </div>

                {{-- Remarks --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-comment-alt text-secondary"></i> Remarks
                    </div>

                    <div class="card-body">
                        <textarea name="remarks" rows="4" class="form-control">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Save Maintenance Record
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>

@endsection
