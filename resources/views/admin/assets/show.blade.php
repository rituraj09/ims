{{-- resources/views/admin/assets/show.blade.php --}}
@extends('layouts.app')
@section('title', $asset->asset_tag)

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.assets.index') }}">Assets</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">{{ $asset->asset_tag }}</span>
@endsection

@section('page-title', $asset->name)
@section('page-subtitle', 'Asset Tag: ' . $asset->asset_tag)

@section('page-actions')
    <div class="d-flex gap-2 flex-wrap">
        @can('assets.assign')
            @if ($asset->status === 'available')
                <a href="{{ route('admin.assets.assign', $asset) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-share"></i> Assign
                </a>
            @endif
            @if ($asset->status === 'in_use')
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#takeoverModal">
                    <i class="fas fa-reply"></i> Take Back
                </button>
                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transferModal">
                    <i class="fas fa-exchange-alt"></i> Transfer
                </button>
            @endif
        @endcan
        @can('assets.edit')
            <a href="{{ route('admin.assets.edit', $asset) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-pen"></i> Edit
            </a>
        @endcan
        <a href="{{ route('admin.assets.print', $asset) }}" class="btn btn-outline-danger btn-sm" target="_blank">
            <i class="fas fa-print"></i> Print
        </a>
        <a href="{{ route('admin.assets.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')

    {{-- Status Bar --}}
    <div class="alert border-0 mb-3 d-flex align-items-center gap-3 py-3"
        style="background: linear-gradient(135deg, #f8fafc, #eff6ff);">
        <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1">
            @php
                $statusColors = [
                    'available' => 'success',
                    'in_use' => 'primary',
                    'under_maintenance' => 'warning',
                    'disposed' => 'danger',
                    'lost' => 'dark',
                    'transferred' => 'info',
                ];
                $condColors = [
                    'new' => 'success',
                    'good' => 'info',
                    'fair' => 'warning',
                    'poor' => 'danger',
                    'condemned' => 'dark',
                ];
            @endphp
            <span
                class="status-pill text-{{ $statusColors[$asset->status] ?? 'secondary' }} bg-{{ $statusColors[$asset->status] ?? 'secondary' }} bg-opacity-10 fs-6">
                <i class="fas fa-circle-dot me-1"></i>{{ $asset->status_label }}
            </span>
            <span
                class="badge bg-{{ $condColors[$asset->condition] ?? 'secondary' }} bg-opacity-10 text-{{ $condColors[$asset->condition] ?? 'secondary' }}">
                Condition: {{ ucfirst($asset->condition) }}
            </span>
            @if ($asset->isUnderWarranty())
                <span class="badge bg-success bg-opacity-10 text-success">
                    <i class="fas fa-shield-halved me-1"></i>Under Warranty
                </span>
            @endif
            @if ($asset->isAmcActive())
                <span class="badge bg-info bg-opacity-10 text-info">
                    <i class="fas fa-file-contract me-1"></i>AMC Active
                </span>
            @endif
        </div>
        <div class="text-muted text-sm">
            Added {{ $asset->created_at->diffForHumans() }}
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">

            {{-- Basic Info --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-info-circle text-primary"></i> Asset Information
                </div>
                <div class="card-body">
                    <div class="row g-0">
                        @php
                            $details = [
                                ['Asset Tag', $asset->asset_tag, 'code'],
                                ['Category', $asset->category?->name, 'text'],
                                ['Sub-Category', $asset->sub_category_name, 'text'],
                                ['Asset Type', $asset->asset_type, 'text'],
                                ['Make / Brand', $asset->make_brand, 'text'],
                                ['Model', $asset->model, 'text'],
                                ['Serial No.', $asset->serial_no, 'text'],
                                ['Description', $asset->description, 'text'],
                            ];
                        @endphp
                        @foreach ($details as [$label, $value, $type])
                            @if ($value)
                                <div class="col-md-6 border-bottom border-end-md py-2 px-3">
                                    <div class="text-xs text-muted fw-700 text-uppercase mb-1">{{ $label }}</div>
                                    @if ($type === 'code')
                                        <code class="text-primary fs-6">{{ $value }}</code>
                                    @else
                                        <div class="fw-500">{{ $value }}</div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Purchase & Financial --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-rupee-sign text-success"></i> Purchase & Financial Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Purchase Date</div>
                            <div class="fw-600">{{ $asset->purchase_date?->format('d/m/Y') ?? '—' }}</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Purchase Price</div>
                            <div class="fw-700 text-primary fs-5">
                                {{ $asset->purchase_price ? '₹ ' . number_format($asset->purchase_price, 2) : '—' }}
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Current Value</div>
                            <div class="fw-700 text-success fs-5">
                                {{ $asset->current_value ? '₹ ' . number_format($asset->current_value, 2) : '—' }}
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Depreciation</div>
                            <div class="fw-600 text-danger">
                                {{ $asset->depreciation_rate ? $asset->depreciation_rate . '% p.a.' : '—' }}
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                        </div>
                        <div class="col-md-4">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Vendor</div>
                            <div class="fw-500">{{ $asset->vendor?->name ?? '—' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Invoice No.</div>
                            <div class="fw-500">{{ $asset->invoice_no ?? '—' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-xs text-muted fw-700 text-uppercase mb-1">Warranty Expiry</div>
                            <div
                                class="fw-500 {{ $asset->warranty_expiry_date && $asset->warranty_expiry_date->isPast() ? 'text-danger' : '' }}">
                                {{ $asset->warranty_expiry_date?->format('d/m/Y') ?? '—' }}
                                @if ($asset->warranty_expiry_date && $asset->warranty_expiry_date->isPast())
                                    <span class="badge bg-danger ms-1">Expired</span>
                                @endif
                            </div>
                        </div>
                        @if ($asset->under_amc)
                            <div class="col-12">
                                <div class="alert alert-info py-2 mb-0 d-flex align-items-center gap-2">
                                    <i class="fas fa-file-contract"></i>
                                    <span>
                                        <strong>Under AMC</strong> —
                                        {{ $asset->amc_start_date?->format('d/m/Y') }} to
                                        {{ $asset->amc_end_date?->format('d/m/Y') }}
                                        @if ($asset->amc_reference_no)
                                            | Ref: {{ $asset->amc_reference_no }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Assignment History --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history text-info"></i> Assignment History</span>
                    <span class="badge bg-secondary">{{ $asset->assignments->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-sm">
                            <thead>
                                <tr>
                                    <th>Form No</th>
                                    <th>Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asset->assignments as $asgn)
                                    <tr>
                                        <td><code class="text-primary">{{ $asgn->form_no ?? '—' }}</code></td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ ucfirst($asgn->transaction_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $asgn->from_holder_name }}</td>
                                        <td>{{ $asgn->to_holder_name }}</td>
                                        <td>{{ $asgn->transaction_date->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.assignments.show', $asgn->id) }}"
                                                class="btn btn-icon btn-sm btn-outline-info">
                                                <i class="fas fa-eye fa-xs"></i>
                                            </a>
                                            <a href="{{ route('admin.assignments.print', $asgn->id) }}"
                                                class="btn btn-icon btn-sm btn-outline-secondary" target="_blank">
                                                <i class="fas fa-print fa-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">No assignment history</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-paperclip text-warning"></i> Documents</span>
                </div>
                <div class="card-body">
                    @if ($asset->documents->count())
                        <div class="row g-2">
                            @foreach ($asset->documents as $doc)
                                <div class="col-md-6">
                                    <div class="border rounded p-2 d-flex align-items-center gap-2">
                                        <i class="{{ $doc->icon_class }} fa-lg"></i>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-600 text-sm text-truncate">{{ $doc->title }}</div>
                                            <div class="text-xs text-muted">{{ $doc->file_size_formatted }}</div>
                                        </div>
                                        <a href="{{ route('admin.documents.download', $doc) }}"
                                            class="btn btn-icon btn-sm btn-outline-primary">
                                            <i class="fas fa-download fa-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3 mb-0">
                            <i class="fas fa-file fa-2x opacity-25 d-block mb-2"></i>
                            No documents uploaded
                        </p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Right Panel --}}
        <div class="col-lg-4">

            {{-- Current Assignment --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt text-danger"></i> Current Location
                </div>
                <div class="card-body">
                    @if ($asset->assigned_to_type)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                style="width:44px;height:44px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                                <i
                                    class="fas fa-{{ $asset->assigned_to_type === 'department' ? 'building' : 'user' }} text-primary"></i>
                            </div>
                            <div>
                                <div class="text-xs text-muted fw-700 text-uppercase">
                                    {{ $asset->assigned_to_type === 'department' ? 'Department' : 'Employee' }}
                                </div>
                                <div class="fw-700">
                                    @if ($asset->assigned_to_type === 'department')
                                        {{ $asset->assignedDepartment?->name ?? '—' }}
                                    @else
                                        {{ $asset->assignedEmployee?->name ?? '—' }}
                                        @if ($asset->assignedEmployee?->designation)
                                            <div class="text-xs text-muted">
                                                {{ $asset->assignedEmployee->designation->name }}</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-2 text-sm">
                            @if ($asset->location_building)
                                <div class="mb-1"><i
                                        class="fas fa-building text-muted me-2"></i>{{ $asset->location_building }}</div>
                            @endif
                            @if ($asset->location_floor)
                                <div class="mb-1"><i class="fas fa-layer-group text-muted me-2"></i>Floor:
                                    {{ $asset->location_floor }}</div>
                            @endif
                            @if ($asset->location_room_no)
                                <div class="mb-1"><i class="fas fa-door-open text-muted me-2"></i>Room:
                                    {{ $asset->location_room_no }}</div>
                            @endif
                            @if ($asset->assigned_on)
                                <div class="mb-1"><i class="fas fa-calendar text-muted me-2"></i>Since:
                                    {{ $asset->assigned_on->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-warehouse fa-2x opacity-25 d-block mb-2"></i>
                            Not currently assigned
                        </div>
                    @endif
                </div>
            </div>

            {{-- Maintenance Summary --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-screwdriver-wrench text-warning"></i> Maintenance</span>
                    @can('maintenance.create')
                        <a href="{{ route('admin.maintenances.create', ['asset_id' => $asset->id]) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body p-0">
                    @forelse($asset->maintenances->take(5) as $maint)
                        <div class="d-flex align-items-center gap-2 px-3 py-2 border-bottom">
                            <span class="badge bg-{{ $maint->status_color }}">{{ ucfirst($maint->status) }}</span>
                            <div class="flex-grow-1 text-sm">
                                <div>{{ ucfirst($maint->maintenance_type) }}</div>
                                <div class="text-xs text-muted">{{ $maint->start_date->format('d/m/Y') }}</div>
                            </div>
                            @if ($maint->maintenance_cost)
                                <div class="text-sm fw-600 text-success">₹{{ number_format($maint->maintenance_cost) }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted text-sm">No maintenance records</div>
                    @endforelse
                </div>
            </div>

            {{-- Meta Info --}}
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-circle-info text-secondary"></i> Record Info
                </div>
                <div class="card-body text-sm">
                    <div class="mb-2">
                        <span class="text-muted">Created by:</span>
                        <span class="fw-600 ms-1">{{ $asset->createdBy?->name ?? 'System' }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Created on:</span>
                        <span class="fw-600 ms-1">{{ $asset->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if ($asset->updatedBy)
                        <div class="mb-2">
                            <span class="text-muted">Last updated by:</span>
                            <span class="fw-600 ms-1">{{ $asset->updatedBy->name }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Takeover Modal --}}
    <div class="modal fade" id="takeoverModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.assets.takeover', $asset) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-reply me-2"></i>Take Back Asset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Condition at Return <span class="text-danger">*</span></label>
                            <select name="condition_at_return" class="form-select" required>
                                <option value="new">New</option>
                                <option value="good" selected>Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                                <option value="condemned">Condemned</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Return Date <span class="text-danger">*</span></label>
                            <input type="text" name="transaction_date" class="form-control datepicker"
                                value="{{ date('d/m/Y') }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-reply"></i> Take Back
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Transfer Modal --}}
    <div class="modal fade" id="transferModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.assets.transfer', $asset) }}" method="POST">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Transfer Asset
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">
                                Transfer To <span class="text-danger">*</span>
                            </label>

                            <select name="to_type" id="to_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="department">Department</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none department-field" id="transferDepartmentDiv">
                            <label class="form-label">
                                Department
                            </label>

                            <select name="to_department_id" class="form-select">
                                <option value="">Select Department</option>

                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 d-none employee-field" id="transferEmployeeDiv">
                            <label class="form-label">
                                Employee
                            </label>

                            <select name="to_employee_id" class="form-select">
                                <option value="">Select Employee</option>

                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Transfer Date
                            </label>

                            <input type="text" name="transaction_date" class="form-control datepicker"
                                value="{{ now()->format('d/m/Y') }}" required>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">
                                Remarks
                            </label>

                            <textarea name="remarks" class="form-control" rows="2"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-exchange-alt"></i>
                            Transfer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('to_type').addEventListener('change', function() {

            document.querySelector('.department-field')
                .classList.toggle('d-none', this.value !== 'department');

            document.querySelector('.employee-field')
                .classList.toggle('d-none', this.value !== 'employee');
        });
    </script>

@endsection
