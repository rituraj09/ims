{{-- resources/views/admin/categories/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Add Category')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.categories.index') }}">Categories</a>
<span class="bc-sep">/</span>
<span class="bc-current">Add New</span>
@endsection

@section('page-title', 'Add Asset Category')
@section('page-subtitle', 'Create a new asset category')

@section('page-actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Back
</a>
@endsection

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST"
      class="needs-validation" novalidate>
@csrf

<div class="row g-3">

    {{-- Main Form --}}
    <div class="col-lg-8">

        {{-- Basic Info --}}
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-info-circle text-primary"></i> Basic Information
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. IT Equipment" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Category Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code') }}" placeholder="e.g. IT"
                               style="text-transform:uppercase;" required>
                        <div class="form-text">Used in Asset Tag generation</div>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                                  placeholder="Optional description...">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Depreciation Rate (% p.a.)</label>
                        <div class="input-group">
                            <input type="number" name="depreciation_rate"
                                   class="form-control @error('depreciation_rate') is-invalid @enderror"
                                   value="{{ old('depreciation_rate') }}"
                                   placeholder="e.g. 33.33" step="0.01" min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">WDV depreciation rate per annum</div>
                        @error('depreciation_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sub Categories --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-sitemap text-primary"></i> Sub-Categories</span>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addSubCatBtn">
                    <i class="fas fa-plus"></i> Add Sub-Category
                </button>
            </div>
            <div class="card-body">
                <div id="subCategoryContainer">
                    <p class="text-muted text-sm text-center py-3" id="noSubCatMsg">
                        <i class="fas fa-sitemap opacity-25 d-block fa-2x mb-2"></i>
                        No sub-categories added yet
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Icon Selector --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-icons text-primary"></i> Category Icon
            </div>
            <div class="card-body">
                <label class="form-label">Select Icon</label>
                <select name="icon" class="form-select select2" id="iconSelect">
                    <option value="">-- No Icon --</option>
                    @foreach($icons as $class => $label)
                    <option value="{{ $class }}" {{ old('icon') === $class ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>

                <div class="mt-3 p-3 bg-light rounded text-center" id="iconPreview">
                    <div id="iconPreviewBox"
                         style="width:56px;height:56px;border-radius:14px;background:#3b82f6;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;font-size:22px;color:#fff;">
                        <i class="fas fa-boxes-stacked" id="previewIcon"></i>
                    </div>
                    <div class="text-sm text-muted" id="previewIconClass">fas fa-boxes-stacked</div>
                </div>
            </div>
        </div>

        {{-- Quick Tips --}}
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lightbulb text-warning"></i> Tips
            </div>
            <div class="card-body">
                <ul class="list-unstyled text-sm text-muted mb-0" style="line-height:2;">
                    <li><i class="fas fa-check text-success me-1"></i> Use short, unique codes</li>
                    <li><i class="fas fa-check text-success me-1"></i> Code is used in asset tag</li>
                    <li><i class="fas fa-check text-success me-1"></i> Depreciation auto-applied</li>
                    <li><i class="fas fa-check text-success me-1"></i> Sub-categories help classify</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <div class="col-12">
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </div>

</div>

{{-- Hidden Sub-category data --}}
<input type="hidden" name="sub_categories" id="subCategoriesData" value="[]">

</form>
@endsection

@push('scripts')
<script>
let subCategories = [];

// Icon Preview
document.getElementById('iconSelect')?.addEventListener('change', function() {
    const cls  = this.value || 'fas fa-boxes-stacked';
    document.getElementById('previewIcon').className = cls;
    document.getElementById('previewIconClass').textContent = cls;
});

// Add Sub Category
document.getElementById('addSubCatBtn')?.addEventListener('click', function() {
    Swal.fire({
        title: 'Add Sub-Category',
        html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label fw-600">Name <span class="text-danger">*</span></label>
                    <input type="text" id="swal-sub-name" class="form-control" placeholder="e.g. Laptop">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600">Code <span class="text-danger">*</span></label>
                    <input type="text" id="swal-sub-code" class="form-control"
                           placeholder="e.g. LAP" style="text-transform:uppercase;">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-600">Description</label>
                    <textarea id="swal-sub-desc" class="form-control" rows="2"
                              placeholder="Optional..."></textarea>
                </div>
            </div>`,
        showCancelButton: true,
        confirmButtonText: 'Add',
        confirmButtonColor: '#3b82f6',
        preConfirm: () => {
            const name = document.getElementById('swal-sub-name').value.trim();
            const code = document.getElementById('swal-sub-code').value.trim().toUpperCase();
            if (!name || !code) {
                Swal.showValidationMessage('Name and Code are required.');
                return false;
            }
            return {
                id: Date.now().toString(),
                name, code,
                description: document.getElementById('swal-sub-desc').value.trim(),
                status: 'active',
            };
        },
    }).then(result => {
        if (result.isConfirmed) {
            subCategories.push(result.value);
            renderSubCategories();
        }
    });
});

function renderSubCategories() {
    const container = document.getElementById('subCategoryContainer');
    const noMsg     = document.getElementById('noSubCatMsg');

    if (subCategories.length === 0) {
        container.innerHTML = `<p class="text-muted text-sm text-center py-3" id="noSubCatMsg">
            <i class="fas fa-sitemap opacity-25 d-block fa-2x mb-2"></i>No sub-categories added yet</p>`;
        document.getElementById('subCategoriesData').value = '[]';
        return;
    }

    let html = '<div class="list-group list-group-flush">';
    subCategories.forEach((sub, idx) => {
        html += `
        <div class="list-group-item d-flex align-items-center gap-3 px-0">
            <div class="flex-grow-1">
                <span class="fw-600">${sub.name}</span>
                <code class="ms-2 text-primary small">${sub.code}</code>
                ${sub.description ? `<div class="text-muted text-xs">${sub.description}</div>` : ''}
            </div>
            <span class="badge ${sub.status==='active'?'bg-success':'bg-secondary'}">${sub.status}</span>
            <button type="button" class="btn btn-icon btn-sm btn-outline-danger"
                    onclick="removeSubCat(${idx})">
                <i class="fas fa-trash fa-xs"></i>
            </button>
        </div>`;
    });
    html += '</div>';
    container.innerHTML = html;
    document.getElementById('subCategoriesData').value = JSON.stringify(subCategories);
}

function removeSubCat(idx) {
    subCategories.splice(idx, 1);
    renderSubCategories();
}
</script>
@endpush
