{{-- resources/views/admin/roles/permissions.blade.php --}}
@extends('layouts.app')
@section('title', 'Manage Permissions - ' . $role->display_name)

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.roles.index') }}">Roles</a>
<span class="bc-sep">/</span>
<span class="bc-current">{{ $role->display_name }}</span>
@endsection

@section('page-title', 'Permissions: ' . $role->display_name)
@section('page-subtitle', 'Configure what this role can access')

@section('page-actions')
<a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Back
</a>
@endsection

@section('content')
<form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
@csrf

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-key text-primary me-2"></i>Permission Matrix</span>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-success" id="checkAll">
                <i class="fas fa-check-double"></i> Select All
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" id="uncheckAll">
                <i class="fas fa-times"></i> Clear All
            </button>
        </div>
    </div>
    <div class="card-body">
        @foreach($permissions as $module => $modulePermissions)
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:6px;height:20px;background:var(--primary);border-radius:3px;"></div>
                <h6 class="fw-800 text-uppercase mb-0" style="letter-spacing:.5px;font-size:12px;">
                    {{ ucfirst($module) }}
                </h6>
                <div class="flex-grow-1" style="height:1px;background:#e2e8f0;"></div>
                <label class="d-flex align-items-center gap-1 text-xs text-muted" style="cursor:pointer;">
                    <input type="checkbox" class="module-toggle" data-module="{{ $module }}">
                    Select all
                </label>
            </div>
            <div class="row g-2">
                @foreach($modulePermissions as $permission)
                <div class="col-md-4 col-6">
                    <label class="d-flex align-items-center gap-2 p-2 border rounded-2 cursor-pointer hover-bg"
                           style="cursor:pointer;transition:all .15s;">
                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               class="form-check-input perm-check {{ $module }}-perm"
                               {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                        <span class="text-sm">{{ $permission->display_name }}</span>
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span class="text-sm text-muted">
            <span id="checkedCount">0</span> permissions selected
        </span>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Permissions
        </button>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
// Count checked
function updateCount() {
    const count = document.querySelectorAll('.perm-check:checked').length;
    document.getElementById('checkedCount').textContent = count;
}

document.querySelectorAll('.perm-check').forEach(cb => {
    cb.addEventListener('change', updateCount);
});

// Select/deselect all
document.getElementById('checkAll').addEventListener('click', () => {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = true);
    document.querySelectorAll('.module-toggle').forEach(cb => cb.checked = true);
    updateCount();
});

document.getElementById('uncheckAll').addEventListener('click', () => {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = false);
    document.querySelectorAll('.module-toggle').forEach(cb => cb.checked = false);
    updateCount();
});

// Module toggle
document.querySelectorAll('.module-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const module = this.dataset.module;
        document.querySelectorAll(`.${module}-perm`).forEach(cb => {
            cb.checked = this.checked;
        });
        updateCount();
    });
});

updateCount();
</script>
@endpush
