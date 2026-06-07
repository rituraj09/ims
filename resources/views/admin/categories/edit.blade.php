{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Category')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <a href="{{ route('admin.categories.index') }}">Categories</a>
    <span class="bc-sep">/</span>
    <span class="bc-current">Edit</span>
@endsection

@section('page-title', 'Edit Asset Category')
@section('page-subtitle', 'Update category information')

@section('page-actions')
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-primary"></i>
                        Basic Information
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-8">
                                <label class="form-label">
                                    Category Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Category Code <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $category->code) }}" style="text-transform: uppercase;" required>

                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>

                                <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Depreciation Rate (%)</label>

                                <div class="input-group">
                                    <input type="number" name="depreciation_rate" class="form-control"
                                        value="{{ old('depreciation_rate', $category->depreciation_rate) }}" step="0.01"
                                        min="0" max="100">

                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select name="status" class="form-select">
                                    <option value="active"
                                        {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Sub Categories --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-sitemap text-primary"></i>
                            Sub-Categories
                        </span>

                        <button type="button" class="btn btn-sm btn-outline-primary" id="addSubCatBtn">
                            <i class="fas fa-plus"></i> Add Sub-Category
                        </button>
                    </div>

                    <div class="card-body">
                        <div id="subCategoryContainer"></div>
                    </div>
                </div>

            </div>

            {{-- Right Sidebar --}}
            <div class="col-lg-4">

                {{-- Icon --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-icons text-primary"></i>
                        Category Icon
                    </div>

                    <div class="card-body">

                        <select name="icon" id="iconSelect" class="form-select select2">

                            <option value="">-- No Icon --</option>

                            @foreach ($icons as $class => $label)
                                <option value="{{ $class }}"
                                    {{ old('icon', $category->icon) == $class ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <div class="mt-3 p-3 bg-light rounded text-center">
                            <div id="iconPreviewBox"
                                style="width:56px;height:56px;border-radius:14px;background:#3b82f6;
                             display:flex;align-items:center;justify-content:center;
                             margin:0 auto 8px;font-size:22px;color:#fff;">

                                <i id="previewIcon" class="{{ $category->icon ?: 'fas fa-boxes-stacked' }}"></i>
                            </div>

                            <div id="previewIconClass" class="text-muted small">
                                {{ $category->icon ?: 'fas fa-boxes-stacked' }}
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Info --}}
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-info"></i>
                        Information
                    </div>

                    <div class="card-body">
                        <div class="small text-muted">
                            <p><strong>Created:</strong><br>
                                {{ $category->created_at?->format('d M Y h:i A') }}
                            </p>

                            <p class="mb-0"><strong>Total Assets:</strong><br>
                                {{ $category->assets()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Category
                </button>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>

        </div>

        <input type="hidden" name="sub_categories" id="subCategoriesData">
    </form>
@endsection

@push('scripts')
    <script>
        let subCategories = @json(old('sub_categories') ? json_decode(old('sub_categories'), true) : $category->sub_categories ?? []);

        document.getElementById('iconSelect').addEventListener('change', function() {

            const icon = this.value || 'fas fa-boxes-stacked';

            document.getElementById('previewIcon').className = icon;
            document.getElementById('previewIconClass').innerText = icon;
        });

        function renderSubCategories() {
            const container = document.getElementById('subCategoryContainer');

            if (!subCategories.length) {

                container.innerHTML = `
            <p class="text-center text-muted py-3">
                No sub-categories available
            </p>
        `;

                document.getElementById('subCategoriesData').value = '[]';
                return;
            }

            let html = '<div class="list-group list-group-flush">';

            subCategories.forEach((sub, index) => {

                html += `
            <div class="list-group-item d-flex justify-content-between align-items-center">

                <div>
                    <strong>${sub.name}</strong>
                    <code class="ms-2">${sub.code}</code>

                    ${sub.description
                        ? `<div class="text-muted small">${sub.description}</div>`
                        : ''}
                </div>

                <button type="button"
                        class="btn btn-sm btn-outline-danger"
                        onclick="removeSubCategory(${index})">
                    <i class="fas fa-trash"></i>
                </button>

            </div>
        `;
            });

            html += '</div>';

            container.innerHTML = html;

            document.getElementById('subCategoriesData').value =
                JSON.stringify(subCategories);
        }

        function removeSubCategory(index) {
            subCategories.splice(index, 1);
            renderSubCategories();
        }

        document.getElementById('addSubCatBtn').addEventListener('click', () => {

            Swal.fire({
                title: 'Add Sub Category',

                html: `
            <input id="subName" class="form-control mb-2" placeholder="Name">
            <input id="subCode" class="form-control mb-2" placeholder="Code">
            <textarea id="subDesc" class="form-control" placeholder="Description"></textarea>
        `,

                showCancelButton: true,

                preConfirm: () => {

                    const name = document.getElementById('subName').value.trim();
                    const code = document.getElementById('subCode').value.trim().toUpperCase();

                    if (!name || !code) {
                        Swal.showValidationMessage('Name and Code required');
                        return false;
                    }

                    return {
                        id: Date.now().toString(),
                        name: name,
                        code: code,
                        description: document.getElementById('subDesc').value,
                        status: 'active'
                    };
                }

            }).then(result => {

                if (result.isConfirmed) {
                    subCategories.push(result.value);
                    renderSubCategories();
                }
            });
        });

        renderSubCategories();
    </script>
@endpush
