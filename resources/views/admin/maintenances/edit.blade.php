{{-- resources/views/admin/maintenances/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Maintenance')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.maintenances.index') }}">Maintenance</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Maintenance Record')
@section('page-subtitle', $maintenance->asset->asset_tag . ' • ' . ucfirst($maintenance->maintenance_type))

@section('page-actions')
    <a href="{{ route('admin.maintenances.show', $maintenance) }}" class="btn btn-outline-info">
        <i class="fas fa-eye"></i> View
    </a>

    <a href="{{ route('admin.maintenances.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')

    <form action="{{ route('admin.maintenances.update', $maintenance) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- LEFT SIDE --}}
            <div class="col-lg-8">

                {{-- Asset Information --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-laptop text-primary"></i> Asset Information
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Asset</label>

                            <input type="text" class="form-control"
                                value="{{ $maintenance->asset->asset_tag }} - {{ $maintenance->asset->name }}" readonly>

                            <input type="hidden" name="asset_id" value="{{ $maintenance->asset_id }}">
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Maintenance Type <span class="text-danger">*</span>
                                </label>

                                <select name="maintenance_type" class="form-select" required>

                                    <option value="preventive" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'preventive')>
                                        Preventive
                                    </option>

                                    <option value="corrective" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'corrective')>
                                        Corrective
                                    </option>

                                    <option value="amc" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'amc')>
                                        AMC
                                    </option>

                                    <option value="calibration" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'calibration')>
                                        Calibration
                                    </option>

                                    <option value="inspection" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'inspection')>
                                        Inspection
                                    </option>

                                    <option value="other" @selected(old('maintenance_type', $maintenance->maintenance_type) == 'other')>
                                        Other
                                    </option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reference No.</label>

                                <input type="text" name="reference_no" class="form-control"
                                    value="{{ old('reference_no', $maintenance->reference_no) }}">
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
                                    value="{{ old('scheduled_date', optional($maintenance->scheduled_date)->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Start Date <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="start_date" class="form-control"
                                    value="{{ old('start_date', $maintenance->start_date?->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Completion Date</label>

                                <input type="date" name="completion_date" class="form-control"
                                    value="{{ old('completion_date', $maintenance->completion_date?->format('Y-m-d')) }}">
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
                                        <option value="{{ $vendor->id }}" @selected(old('vendor_id', $maintenance->vendor_id) == $vendor->id)>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Technician Name</label>

                                <input type="text" name="technician_name" class="form-control"
                                    value="{{ old('technician_name', $maintenance->technician_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Technician Contact</label>

                                <input type="text" name="technician_contact" class="form-control"
                                    value="{{ old('technician_contact', $maintenance->technician_contact) }}">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Maintenance Details --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-tools text-danger"></i> Maintenance Details
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Issue Description</label>

                            <textarea name="issue_description" rows="3" class="form-control">{{ old('issue_description', $maintenance->issue_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Work Done</label>

                            <textarea name="work_done" rows="3" class="form-control">{{ old('work_done', $maintenance->work_done) }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Parts Replaced</label>

                            <textarea name="parts_replaced" rows="2" class="form-control">{{ old('parts_replaced', $maintenance->parts_replaced) }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            {{-- RIGHT SIDE --}}
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

                                <option value="scheduled" @selected(old('status', $maintenance->status) == 'scheduled')>
                                    Scheduled
                                </option>

                                <option value="in_progress" @selected(old('status', $maintenance->status) == 'in_progress')>
                                    In Progress
                                </option>

                                <option value="completed" @selected(old('status', $maintenance->status) == 'completed')>
                                    Completed
                                </option>

                                <option value="cancelled" @selected(old('status', $maintenance->status) == 'cancelled')>
                                    Cancelled
                                </option>

                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Condition After</label>

                            <select name="condition_after" class="form-select">

                                <option value="">Select</option>

                                @foreach (['new', 'good', 'fair', 'poor', 'condemned'] as $condition)
                                    <option value="{{ $condition }}" @selected(old('condition_after', $maintenance->condition_after) == $condition)>
                                        {{ ucfirst($condition) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

                {{-- Cost & Invoice --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-file-invoice-dollar text-primary"></i>
                        Cost & Invoice
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Maintenance Cost</label>

                            <input type="number" step="0.01" min="0" name="maintenance_cost"
                                class="form-control"
                                value="{{ old('maintenance_cost', $maintenance->maintenance_cost) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Invoice No.</label>

                            <input type="text" name="invoice_no" class="form-control"
                                value="{{ old('invoice_no', $maintenance->invoice_no) }}">
                        </div>

                        @if ($maintenance->invoice_file)
                            <div class="alert alert-info py-2 small">
                                <i class="fas fa-paperclip"></i>
                                Existing Invoice Attached
                            </div>
                        @endif

                        <div>
                            <label class="form-label">Replace Invoice File</label>

                            <input type="file" name="invoice_file" class="form-control">
                        </div>

                    </div>
                </div>

                {{-- Remarks --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-comment-alt text-secondary"></i>
                        Remarks
                    </div>

                    <div class="card-body">

                        <textarea name="remarks" rows="4" class="form-control">{{ old('remarks', $maintenance->remarks) }}</textarea>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="card">
                    <div class="card-body">

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i>
                            Update Maintenance Record
                        </button>

                    </div>
                </div>

            </div>

        </div>
    </form>

@endsection
