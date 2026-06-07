{{-- resources/views/admin/assets/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Asset')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.assets.index') }}">Assets</a>
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.assets.show', $asset->id) }}">{{ $asset->asset_tag }}</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Asset')
@section('page-subtitle', 'Update asset details — ' . $asset->asset_tag)

@section('page-actions')
    <a href="{{ route('admin.assets.show', $asset->id) }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-eye"></i> View
    </a>
    <a href="{{ route('admin.assets.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data"
        class="needs-validation" novalidate id="assetForm">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-8">

                {{-- ============================================================
                     CARD 1 — Asset Identity
                ============================================================ --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-barcode text-primary"></i> Asset Identity
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Asset Tag --}}
                            <div class="col-md-4">
                                <label class="form-label">
                                    Asset Tag <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="asset_tag" id="assetTagInput"
                                        class="form-control @error('asset_tag') is-invalid @enderror"
                                        value="{{ old('asset_tag', $asset->asset_tag) }}" placeholder="Auto-generated"
                                        readonly>
                                    <button type="button" class="btn btn-outline-primary" id="genTagBtn"
                                        title="Re-generate Tag">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('asset_tag')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Asset Type --}}
                            <div class="col-md-4">
                                <label class="form-label">Asset Type</label>
                                <select name="asset_type" class="form-select">
                                    <option value="">-- Select Type --</option>
                                    @foreach (['Movable', 'Immovable', 'IT', 'Non-IT', 'Furniture', 'Vehicle'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('asset_type', $asset->asset_type) === $type ? 'selected' : '' }}>
                                            {{ $type === 'IT' ? 'IT Equipment' : ($type === 'Non-IT' ? 'Non-IT Equipment' : $type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" class="form-select" required>
                                    @foreach ([
            'available' => 'Available',
            'in_use' => 'In Use',
            'under_maintenance' => 'Under Maintenance',
            'disposed' => 'Disposed',
            'lost' => 'Lost',
        ] as $val => $label)
                                        <option value="{{ $val }}"
                                            {{ old('status', $asset->status) === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Asset Name --}}
                            <div class="col-12">
                                <label class="form-label">
                                    Asset Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $asset->name) }}"
                                    placeholder="Full descriptive name of the asset" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select name="category_id" id="categorySelect"
                                    class="form-select select2 @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" data-rate="{{ $cat->depreciation_rate }}"
                                            {{ old('category_id', $asset->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }} ({{ $cat->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sub-Category --}}
                            <div class="col-md-6">
                                <label class="form-label">Sub-Category</label>
                                <select name="sub_category_id" id="subCategorySelect" class="form-select"
                                    data-selected-id="{{ old('sub_category_id', $asset->sub_category_id) }}"
                                    data-selected-name="{{ old('sub_category_name', $asset->sub_category_name) }}">
                                    <option value="">-- Select Sub-Category --</option>
                                </select>

                                <input type="hidden" name="sub_category_name" id="subCategoryName"
                                    value="{{ old('sub_category_name', $asset->sub_category_name) }}">
                            </div>

                            {{-- Make / Brand --}}
                            <div class="col-md-4">
                                <label class="form-label">Make / Brand</label>
                                <input type="text" name="make_brand" class="form-control"
                                    value="{{ old('make_brand', $asset->make_brand) }}"
                                    placeholder="e.g. Dell, HP, Samsung">
                            </div>

                            {{-- Model --}}
                            <div class="col-md-4">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control"
                                    value="{{ old('model', $asset->model) }}" placeholder="e.g. Latitude 5520">
                            </div>

                            {{-- Serial No --}}
                            <div class="col-md-4">
                                <label class="form-label">Serial Number</label>
                                <input type="text" name="serial_no"
                                    class="form-control @error('serial_no') is-invalid @enderror"
                                    value="{{ old('serial_no', $asset->serial_no) }}"
                                    placeholder="Manufacturer serial no">
                                @error('serial_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Condition --}}
                            <div class="col-md-4">
                                <label class="form-label">
                                    Condition <span class="text-danger">*</span>
                                </label>
                                <select name="condition" class="form-select" required>
                                    @foreach ([
            'new' => 'New',
            'good' => 'Good',
            'fair' => 'Fair',
            'poor' => 'Poor',
            'condemned' => 'Condemned',
        ] as $val => $label)
                                        <option value="{{ $val }}"
                                            {{ old('condition', $asset->condition) === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Optional description...">{{ old('description', $asset->description) }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ============================================================
                     CARD 2 — Purchase & Financial
                ============================================================ --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-rupee-sign text-success"></i> Purchase & Financial Details
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Purchase Date --}}
                            <div class="col-md-4">
                                <label class="form-label">Purchase Date</label>
                                <input type="text" name="purchase_date" class="form-control datepicker"
                                    value="{{ old(
                                        'purchase_date',
                                        $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d/m/Y') : '',
                                    ) }}"
                                    placeholder="dd/mm/yyyy">
                            </div>

                            {{-- Purchase Price --}}
                            <div class="col-md-4">
                                <label class="form-label">Purchase Price (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="purchase_price" id="purchasePrice" class="form-control"
                                        value="{{ old('purchase_price', $asset->purchase_price) }}" placeholder="0.00"
                                        step="0.01" min="0">
                                </div>
                            </div>

                            {{-- Warranty Expiry --}}
                            <div class="col-md-4">
                                <label class="form-label">Warranty Expiry Date</label>
                                <input type="text" name="warranty_expiry_date" class="form-control datepicker"
                                    value="{{ old(
                                        'warranty_expiry_date',
                                        $asset->warranty_expiry_date ? \Carbon\Carbon::parse($asset->warranty_expiry_date)->format('d/m/Y') : '',
                                    ) }}"
                                    placeholder="dd/mm/yyyy">
                            </div>

                            {{-- Vendor --}}
                            <div class="col-md-4">
                                <label class="form-label">Vendor</label>
                                <select name="vendor_id" class="form-select select2">
                                    <option value="">-- Select Vendor --</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id', $asset->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Invoice No --}}
                            <div class="col-md-4">
                                <label class="form-label">Invoice Number</label>
                                <input type="text" name="invoice_no" class="form-control"
                                    value="{{ old('invoice_no', $asset->invoice_no) }}" placeholder="Invoice no.">
                            </div>

                            {{-- Invoice File --}}
                            <div class="col-md-4">
                                <label class="form-label">Invoice File</label>
                                @if ($asset->invoice_file)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/' . $asset->invoice_file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-file me-1"></i> View Current Invoice
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="invoice_file" class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                @if ($asset->invoice_file)
                                    <div class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Upload a new file to replace the existing one
                                    </div>
                                @endif
                            </div>

                            {{-- Depreciation Rate --}}
                            <div class="col-md-4">
                                <label class="form-label">Depreciation Rate (% p.a.)</label>
                                <div class="input-group">
                                    <input type="number" name="depreciation_rate" id="depreciationRate"
                                        class="form-control"
                                        value="{{ old('depreciation_rate', $asset->depreciation_rate) }}"
                                        placeholder="Auto from category" step="0.01" min="0" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            {{-- AMC Toggle --}}
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="under_amc" class="form-check-input" id="underAmc"
                                        value="1" {{ old('under_amc', $asset->under_amc) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-600" for="underAmc">
                                        Under AMC (Annual Maintenance Contract)
                                    </label>
                                </div>
                            </div>

                            {{-- AMC Fields --}}
                            <div id="amcFields" class="{{ old('under_amc', $asset->under_amc) ? '' : 'd-none' }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">AMC Start Date</label>
                                        <input type="text" name="amc_start_date" class="form-control datepicker"
                                            value="{{ old(
                                                'amc_start_date',
                                                $asset->amc_start_date ? \Carbon\Carbon::parse($asset->amc_start_date)->format('d/m/Y') : '',
                                            ) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">AMC End Date</label>
                                        <input type="text" name="amc_end_date" class="form-control datepicker"
                                            value="{{ old(
                                                'amc_end_date',
                                                $asset->amc_end_date ? \Carbon\Carbon::parse($asset->amc_end_date)->format('d/m/Y') : '',
                                            ) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">AMC Reference No.</label>
                                        <input type="text" name="amc_reference_no" class="form-control"
                                            value="{{ old('amc_reference_no', $asset->amc_reference_no) }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                {{-- ============================================================
                     CARD 4 — Audit Trail (Read-Only)
                ============================================================ --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-history text-secondary"></i> Audit Trail
                        </span>
                        <span class="badge bg-secondary">Read Only</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Created By</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $asset->createdBy->name ?? '—' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Created At</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $asset->created_at ? $asset->created_at->format('d M Y, h:i A') : '—' }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Last Updated By</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $asset->updatedBy->name ?? '—' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Last Updated At</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ $asset->updated_at ? $asset->updated_at->format('d M Y, h:i A') : '—' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- end col-lg-8 --}}

            {{-- ================================================================
                 RIGHT SIDEBAR
            ================================================================ --}}
            <div class="col-lg-4">

                {{-- Asset Summary --}}
                <div class="card mb-3" id="assetSummaryCard">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-primary"></i> Asset Summary
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2 text-sm">
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Asset Tag</span>
                                <span class="fw-600 text-primary">{{ $asset->asset_tag }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Purchase Price</span>
                                <span class="fw-600" id="sumPurchasePrice">
                                    ₹ {{ number_format($asset->purchase_price, 2) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Depreciation</span>
                                <span class="fw-600" id="sumDepRate">
                                    {{ $asset->depreciation_rate ? $asset->depreciation_rate . ' %' : '— %' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Est. Current Value</span>
                                <span class="fw-600 text-success" id="sumCurrentValue">
                                    @if ($asset->purchase_price && $asset->depreciation_rate && $asset->purchase_date)
                                        @php
                                            $years = \Carbon\Carbon::parse($asset->purchase_date)->diffInYears(now());
                                            $currentVal =
                                                $asset->purchase_price *
                                                pow(1 - $asset->depreciation_rate / 100, max($years, 1));
                                        @endphp
                                        ₹ {{ number_format($currentVal, 2) }}
                                    @else
                                        ₹ —
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Current Status</span>
                                <span>
                                    @php
                                        $statusColors = [
                                            'available' => 'success',
                                            'in_use' => 'primary',
                                            'under_maintenance' => 'warning',
                                            'disposed' => 'danger',
                                            'lost' => 'dark',
                                        ];
                                        $statusLabels = [
                                            'available' => 'Available',
                                            'in_use' => 'In Use',
                                            'under_maintenance' => 'Under Maintenance',
                                            'disposed' => 'Disposed',
                                            'lost' => 'Lost',
                                        ];
                                        $color = $statusColors[$asset->status] ?? 'secondary';
                                        $label = $statusLabels[$asset->status] ?? ucfirst($asset->status);
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Condition</span>
                                <span class="fw-600 text-capitalize">{{ $asset->condition ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Warranty Status --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-shield-alt text-info"></i> Warranty Status
                    </div>
                    <div class="card-body">
                        @if ($asset->warranty_expiry_date)
                            @php
                                $warrantyDate = \Carbon\Carbon::parse($asset->warranty_expiry_date);
                                $isExpired = $warrantyDate->isPast();
                                $daysRemaining = $warrantyDate->diffInDays(now(), false);
                                $warrantyColor = $isExpired
                                    ? 'danger'
                                    : ($daysRemaining <= -30
                                        ? 'success'
                                        : 'warning');
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Expiry Date</span>
                                <span class="fw-600">
                                    {{ $warrantyDate->format('d M Y') }}
                                </span>
                            </div>
                            <div class="alert alert-{{ $warrantyColor }} py-2 mb-0 small text-center">
                                @if ($isExpired)
                                    <i class="fas fa-times-circle me-1"></i>
                                    Warranty Expired {{ abs($daysRemaining) }} day(s) ago
                                @else
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ abs($daysRemaining) }} day(s) remaining
                                @endif
                            </div>
                        @else
                            <p class="text-muted mb-0 small text-center">
                                <i class="fas fa-minus-circle me-1"></i>
                                No warranty information
                            </p>
                        @endif
                    </div>
                </div>

                {{-- AMC Status --}}
                @if ($asset->under_amc)
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-file-contract text-purple"></i> AMC Status
                        </div>
                        <div class="card-body">
                            @if ($asset->amc_end_date)
                                @php
                                    $amcEnd = \Carbon\Carbon::parse($asset->amc_end_date);
                                    $amcExpired = $amcEnd->isPast();
                                    $amcDays = $amcEnd->diffInDays(now(), false);
                                    $amcColor = $amcExpired ? 'danger' : ($amcDays <= -30 ? 'success' : 'warning');
                                @endphp
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">AMC Period</span>
                                    <span class="small fw-600">
                                        {{ $asset->amc_start_date ? \Carbon\Carbon::parse($asset->amc_start_date)->format('d M Y') : '—' }}
                                        →
                                        {{ $amcEnd->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="alert alert-{{ $amcColor }} py-2 mb-0 small text-center">
                                    @if ($amcExpired)
                                        <i class="fas fa-times-circle me-1"></i>
                                        AMC Expired {{ abs($amcDays) }} day(s) ago
                                    @else
                                        <i class="fas fa-check-circle me-1"></i>
                                        AMC Active — {{ abs($amcDays) }} day(s) left
                                    @endif
                                </div>
                            @endif
                            @if ($asset->amc_reference_no)
                                <div class="mt-2 text-muted small text-center">
                                    Ref: <strong>{{ $asset->amc_reference_no }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif


                {{-- Save Buttons --}}
                <div class="card">
                    <div class="card-body">
                        <button type="submit" form="assetForm" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-1"></i> Update Asset
                        </button>
                        <a href="{{ route('admin.assets.show', $asset->id) }}"
                            class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-eye me-1"></i> View Asset
                        </a>
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-outline-secondary w-100">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>{{-- end sidebar --}}
        </div>
    </form>
    @if (auth()->user()->hasRole('super_admin'))
        {{-- Danger Zone --}}
        <div class="card mb-3 border-danger col-md-6  ">
            <div class="card-header bg-danger bg-opacity-10 text-danger">
                <i class="fas fa-exclamation-triangle"></i> Danger Zone
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Permanently deleting this asset cannot be undone.
                    All related records will also be removed.
                </p>
                <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" id="deleteAssetForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger w-100" id="deleteAssetBtn">
                        <i class="fas fa-trash me-1"></i> Delete This Asset
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(function() {

            // ── Pre-existing values (PHP → JS) ──────────────────────────────────────
            const existingCategoryId = {{ $asset->category_id ?? 'null' }};
            const existingSubCategoryId = "{{ $asset->sub_category_id ?? 'null' }}";

            // ── On page load: load sub-categories for existing category ─────────────
            if (existingCategoryId) {
                loadSubCategories(existingCategoryId, existingSubCategoryId);
            }

            // ── Category Change ──────────────────────────────────────────────────────
            $('#categorySelect').on('change', function() {
                const catId = $(this).val();
                const rate = $(this).find(':selected').data('rate');

                // Auto-fill depreciation rate from category
                if (rate) {
                    $('#depreciationRate').val(rate);
                }

                if (catId) {
                    // Re-generate asset tag
                    $.get('{{ route('admin.assets.generate-tag') }}', {
                        category_id: catId
                    }, function(r) {
                        $('#assetTagInput').val(r.tag);
                    });

                    // Load sub-categories (no pre-selection on manual change)
                    loadSubCategories(catId, null);
                } else {
                    $('#subCategorySelect').html('<option value="">-- Select Sub-Category --</option>');
                }

                updateSummary();
            });

            // ── Generate Tag Button ──────────────────────────────────────────────────
            $('#genTagBtn').on('click', function() {
                const catId = $('#categorySelect').val();
                if (!catId) {
                    toastr.warning('Select a category first.');
                    return;
                }
                $.get('{{ route('admin.assets.generate-tag') }}', {
                    category_id: catId
                }, function(r) {
                    $('#assetTagInput').val(r.tag);
                });
            });

            // ── Load Sub-Categories via AJAX ─────────────────────────────────────────
            function loadSubCategories(catId, preSelectId) {
                $.get(`/admin/ajax/sub-categories/${catId}`, function(r) {

                    let opts = '<option value="">-- Select Sub-Category --</option>';

                    r.data.forEach(function(s) {

                        const selected =
                            preSelectId &&
                            String(preSelectId) === String(s.id) ?
                            'selected' :
                            '';

                        opts += `
                <option value="${s.id}"
                        data-name="${s.name}"
                        ${selected}>
                    ${s.name}
                </option>`;
                    });

                    $('#subCategorySelect').html(opts);

                    const selectedName =
                        $('#subCategorySelect').find(':selected').data('name') || '';

                    $('#subCategoryName').val(selectedName);
                });
            }
            // ── Sub-category change: update hidden name ──────────────────────────────
            $('#subCategorySelect').on('change', function() {
                $('#subCategoryName').val($(this).find(':selected').data('name') || '');
            });

            // ── Assign To Toggle ────────────────────────────────────────────────────
            $('#assignedToType').on('change', function() {
                const v = this.value;
                $('#deptField').toggleClass('d-none', v !== 'department');
                $('#empField').toggleClass('d-none', v !== 'employee');
            });

            // ── AMC Toggle ───────────────────────────────────────────────────────────
            $('#underAmc').on('change', function() {
                $('#amcFields').toggleClass('d-none', !this.checked);
            });

            // ── Summary Update ───────────────────────────────────────────────────────
            function updateSummary() {
                const price = parseFloat($('#purchasePrice').val()) || 0;
                const rate = parseFloat($('#depreciationRate').val()) || 0;

                $('#sumPurchasePrice').text(
                    price ?
                    '₹ ' + price.toLocaleString('en-IN', {
                        minimumFractionDigits: 2
                    }) :
                    '₹ —'
                );
                $('#sumDepRate').text(rate ? rate + ' %' : '— %');

                if (price && rate) {
                    const years = 1; // First-year estimate for live preview
                    const current = price * Math.pow(1 - rate / 100, years);
                    $('#sumCurrentValue').text(
                        '₹ ' + current.toLocaleString('en-IN', {
                            minimumFractionDigits: 2
                        })
                    );
                } else {
                    $('#sumCurrentValue').text('₹ —');
                }
            }

            $('#purchasePrice, #depreciationRate').on('input', updateSummary);

            // Run once on load with existing values
            updateSummary();

            // ── Delete Confirmation ──────────────────────────────────────────────────
            $('#deleteAssetBtn').on('click', function() {
                Swal.fire({
                    title: 'Delete Asset?',
                    html: `Are you sure you want to permanently delete
                   <strong>{{ addslashes($asset->name) }}</strong>
                   ({{ $asset->asset_tag }})?<br>
                   <span class="text-danger small">This action cannot be undone.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#deleteAssetForm').submit();
                    }
                });
            });

        });
    </script>
@endpush
