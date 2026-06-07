{{-- resources/views/admin/settings/backup.blade.php --}}
@extends('layouts.app')
@section('title', 'Database Backup')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.settings.general') }}">Settings</a>
<span class="bc-sep">/</span>
<span class="bc-current">Backup</span>
@endsection

@section('page-title', 'Database Backup')
@section('page-subtitle', 'Manage database backups')

@section('content')
<div class="row g-3">
<div class="col-lg-3">
    @include('admin.settings._nav')
</div>
<div class="col-lg-9">

    {{-- Backup Action --}}
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-database text-primary"></i> Create Backup
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <h6 class="fw-700 mb-1">Manual Database Backup</h6>
                    <p class="text-muted text-sm mb-0">
                        Create a complete backup of the database including all tables and records.
                        The backup will be stored in the server storage.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <form action="{{ route('admin.settings.backup.run') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary"
                                onclick="this.disabled=true;this.innerHTML='<span class=\'spinner-border spinner-border-sm me-2\'></span>Creating...'">
                            <i class="fas fa-download"></i> Create Backup Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Backup Settings --}}
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-cog text-primary"></i> Auto Backup Settings
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.notification.update') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Auto Backup</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input"
                               name="auto_backup" value="1"
                               {{ ($settings['auto_backup'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Enable automatic backup</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Frequency</label>
                    <select name="backup_frequency" class="form-select">
                        <option value="daily"   {{ ($settings['backup_frequency'] ?? 'daily') === 'daily'   ? 'selected' : '' }}>Daily</option>
                        <option value="weekly"  {{ ($settings['backup_frequency'] ?? '') === 'weekly'  ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ ($settings['backup_frequency'] ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Retention (Days)</label>
                    <input type="number" name="backup_retention" class="form-control"
                           value="{{ $settings['backup_retention'] ?? 30 }}"
                           min="1" max="365">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>

    {{-- Backup Files List --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-folder-open text-primary"></i> Backup Files
        </div>
        <div class="card-body p-0">
            @if(count($files) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($files as $file)
                        @php $path = storage_path('app/backups/' . $file); @endphp
                        <tr>
                            <td>
                                <i class="fas fa-file-zipper text-warning me-2"></i>
                                <span class="text-sm fw-500">{{ $file }}</span>
                            </td>
                            <td class="text-sm text-muted">
                                {{ file_exists($path) ? number_format(filesize($path) / 1048576, 2) . ' MB' : '—' }}
                            </td>
                            <td class="text-sm text-muted">
                                {{ file_exists($path) ? date('d/m/Y H:i', filemtime($path)) : '—' }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.settings.backup.download', $file) }}"
                                       class="btn btn-icon btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" title="Download">
                                        <i class="fas fa-download fa-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.settings.backup.destroy', $file) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-icon btn-sm btn-outline-danger"
                                                data-confirm="Delete this backup file?"
                                                data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash fa-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-database fa-3x opacity-25 d-block mb-3"></i>
                No backup files found
            </div>
            @endif
        </div>
    </div>

</div>
</div>
@endsection
