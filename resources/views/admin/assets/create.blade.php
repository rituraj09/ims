{{-- resources/views/admin/assets/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Add Asset')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.assets.index') }}">Assets</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Add New</span>
@endsection

@section('page-title', 'Add New Asset')
@section('page-subtitle', 'Register a new asset into the inventory')

@section('page-actions')
    <a href="{{ route('admin.assets.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
        novalidate id="assetForm">
        @csrf

        <div class="row g-3">
            <div class="col-lg-8">

                {{-- Asset Identity --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-barcode text-primary"></i> Asset Identity
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Asset Tag --}}
                            <div class="col-md-4">
                                <label class="form-label">Asset Tag <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="asset_tag" id="assetTagInput"
                                        class="form-control @error('asset_tag') is-invalid @enderror"
                                        value="{{ old('asset_tag') }}" placeholder="Auto-generated" readonly>
                                    <button type="button" class="btn btn-outline-primary" id="genTagBtn"
                                        title="Generate Tag">
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
                                    <option value="Movable" {{ old('asset_type') === 'Movable' ? 'selected' : '' }}>
                                        Movable</option>
                                    <option value="Immovable" {{ old('asset_type') === 'Immovable' ? 'selected' : '' }}>
                                        Immovable</option>
                                    <option value="IT" {{ old('asset_type') === 'IT' ? 'selected' : '' }}>IT
                                        Equipment</option>
                                    <option value="Non-IT" {{ old('asset_type') === 'Non-IT' ? 'selected' : '' }}>Non-IT
                                        Equipment</option>
                                    <option value="Furniture" {{ old('asset_type') === 'Furniture' ? 'selected' : '' }}>
                                        Furniture</option>
                                    <option value="Vehicle" {{ old('asset_type') === 'Vehicle' ? 'selected' : '' }}>
                                        Vehicle</option>
                                </select>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="available"
                                        {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Available
                                    </option>
                                    <option value="in_use" {{ old('status') === 'in_use' ? 'selected' : '' }}>In
                                        Use</option>
                                    <option value="under_maintenance"
                                        {{ old('status') === 'under_maintenance' ? 'selected' : '' }}>Under Maintenance
                                    </option>
                                    <option value="disposed" {{ old('status') === 'disposed' ? 'selected' : '' }}>
                                        Disposed</option>
                                    <option value="lost" {{ old('status') === 'lost' ? 'selected' : '' }}>
                                        Lost</option>
                                </select>
                            </div>

                            {{-- Asset Name --}}
                            <div class="col-12">
                                <label class="form-label">Asset Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Full descriptive name of the asset" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="categorySelect"
                                    class="form-select select2 @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" data-rate="{{ $cat->depreciation_rate }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }} ({{ $cat->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sub Category --}}
                            <div class="col-md-6">
                                <label class="form-label">Sub-Category</label>
                                <select name="sub_category_id" id="subCategorySelect" class="form-select">
                                    <option value="">-- Select Sub-Category --</option>
                                </select>
                                <input type="hidden" name="sub_category_name" id="subCategoryName">
                            </div>

                            {{-- Make/Brand --}}
                            <div class="col-md-4">
                                <label class="form-label">Make / Brand</label>
                                <input type="text" name="make_brand" class="form-control"
                                    value="{{ old('make_brand') }}" placeholder="e.g. Dell, HP, Samsung">
                            </div>

                            {{-- Model --}}
                            <div class="col-md-4">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control" value="{{ old('model') }}"
                                    placeholder="e.g. Latitude 5520">
                            </div>

                            {{-- Serial No --}}
                            <div class="col-md-4">
                                <label class="form-label">Serial Number</label>
                                <input type="text" name="serial_no"
                                    class="form-control @error('serial_no') is-invalid @enderror"
                                    value="{{ old('serial_no') }}" placeholder="Manufacturer serial no">
                                @error('serial_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Condition --}}
                            <div class="col-md-4">
                                <label class="form-label">Condition <span class="text-danger">*</span></label>
                                <select name="condition" class="form-select" required>
                                    <option value="new" {{ old('condition', 'new') === 'new' ? 'selected' : '' }}>
                                        New</option>
                                    <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>Good
                                    </option>
                                    <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>Fair
                                    </option>
                                    <option value="poor" {{ old('condition') === 'poor' ? 'selected' : '' }}>Poor
                                    </option>
                                    <option value="condemned" {{ old('condition') === 'condemned' ? 'selected' : '' }}>
                                        Condemned</option>
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Optional description...">{{ old('description') }}</textarea>
                            </div>

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

                            <div class="col-md-4">
                                <label class="form-label">Purchase Date</label>
                                <input type="text" name="purchase_date" class="form-control datepicker"
                                    value="{{ old('purchase_date') }}" placeholder="dd/mm/yyyy">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Purchase Price (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="purchase_price" class="form-control"
                                        value="{{ old('purchase_price') }}" placeholder="0.00" step="0.01"
                                        min="0" id="purchasePrice">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Warranty Expiry Date</label>
                                <input type="text" name="warranty_expiry_date" class="form-control datepicker"
                                    value="{{ old('warranty_expiry_date') }}" placeholder="dd/mm/yyyy">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Vendor</label>
                                <select name="vendor_id" class="form-select select2">
                                    <option value="">-- Select Vendor --</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Invoice Number</label>
                                <input type="text" name="invoice_no" class="form-control"
                                    value="{{ old('invoice_no') }}" placeholder="Invoice no.">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Invoice File</label>
                                <input type="file" name="invoice_file" class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Depreciation Rate (% p.a.)</label>
                                <div class="input-group">
                                    <input type="number" name="depreciation_rate" id="depreciationRate"
                                        class="form-control" value="{{ old('depreciation_rate') }}"
                                        placeholder="Auto from category" step="0.01" min="0" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            {{-- AMC --}}
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="under_amc" class="form-check-input" id="underAmc"
                                        value="1" {{ old('under_amc') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-600" for="underAmc">
                                        Under AMC (Annual Maintenance Contract)
                                    </label>
                                </div>
                            </div>

                            <div id="amcFields" class="{{ old('under_amc') ? '' : 'd-none' }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">AMC Start Date</label>
                                        <input type="text" name="amc_start_date" class="form-control datepicker"
                                            value="{{ old('amc_start_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">AMC End Date</label>
                                        <input type="text" name="amc_end_date" class="form-control datepicker"
                                            value="{{ old('amc_end_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">AMC Reference No.</label>
                                        <input type="text" name="amc_reference_no" class="form-control"
                                            value="{{ old('amc_reference_no') }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">

                {{-- Summary Card --}}
                <div class="card mb-3" id="assetSummaryCard">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-primary"></i> Asset Summary
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2 text-sm" id="summaryContent">
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Purchase Price</span>
                                <span class="fw-600" id="sumPurchasePrice">₹ —</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted">Depreciation</span>
                                <span class="fw-600" id="sumDepRate">— %</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Est. Current Value</span>
                                <span class="fw-600 text-success" id="sumCurrentValue">₹ —</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save"></i> Save Asset
                        </button>
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-outline-secondary w-100">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // ── Category Change: Load sub-categories & depreciation ──
        $('#categorySelect').on('change', function() {
            const catId = $(this).val();
            const rate = $(this).find(':selected').data('rate');

            // Set depreciation rate
            if (rate) {
                $('#depreciationRate').val(rate);
            }

            // Generate asset tag
            if (catId) {
                $.get('{{ route('admin.assets.generate-tag') }}', {
                    category_id: catId
                }, function(r) {
                    $('#assetTagInput').val(r.tag);
                });

                // Load sub-categories
                $.get(`/admin/ajax/sub-categories/${catId}`, function(r) {
                    let opts = '<option value="">-- Select Sub-Category --</option>';
                    r.data.forEach(s => {
                        opts += `<option value="${s.id}" data-name="${s.name}">${s.name}</option>`;
                    });
                    $('#subCategorySelect').html(opts);
                });
            }

            updateSummary();
        });

        // ── Generate Tag Button ──
        $('#genTagBtn').on('click', function() {
            const catId = $('#categorySelect').val();
            if (!catId) {
                return toastr.warning('Select a category first.');
            }
            $.get('{{ route('admin.assets.generate-tag') }}', {
                category_id: catId
            }, function(r) {
                $('#assetTagInput').val(r.tag);
            });
        });

        // ── Sub-category selection: store name ──
        $('#subCategorySelect').on('change', function() {
            $('#subCategoryName').val($(this).find(':selected').data('name') || '');
        });

        // ── Assign To Toggle ──
        $('#assignedToType').on('change', function() {
            const v = this.value;
            $('#deptField').toggleClass('d-none', v !== 'department');
            $('#empField').toggleClass('d-none', v !== 'employee');
        });

        // Trigger on load if old value
        (function() {
            const v = $('#assignedToType').val();
            if (v === 'department') $('#deptField').removeClass('d-none');
            if (v === 'employee') $('#empField').removeClass('d-none');
        })();

        // ── AMC Toggle ──
        $('#underAmc').on('change', function() {
            $('#amcFields').toggleClass('d-none', !this.checked);
        });

        // ── Summary Update ──
        function updateSummary() {
            const price = parseFloat($('#purchasePrice').val()) || 0;
            const rate = parseFloat($('#depreciationRate').val()) || 0;

            $('#sumPurchasePrice').text('₹ ' + price.toLocaleString('en-IN', {
                minimumFractionDigits: 2
            }));
            $('#sumDepRate').text(rate ? rate + ' %' : '— %');

            if (price && rate) {
                const years = 1; // First year estimate
                const current = price * Math.pow(1 - rate / 100, years);
                $('#sumCurrentValue').text('₹ ' + current.toLocaleString('en-IN', {
                    minimumFractionDigits: 2
                }));
            } else {
                $('#sumCurrentValue').text('₹ —');
            }
        }

        $('#purchasePrice, #depreciationRate').on('input', updateSummary);
    </script>
@endpush
