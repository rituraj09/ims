{{-- resources/views/admin/activity-logs/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Activity Log')

@section('breadcrumb')
<span class="bc-sep">/</span>
<span class="bc-current">Activity Log</span>
@endsection

@section('page-title', 'Activity Log')
@section('page-subtitle', 'Track all system activities and changes')

@section('content')

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3 col-6">
                <select name="module" class="form-select form-select-sm">
                    <option value="">All Modules</option>
                    @foreach(['assets','categories','departments','employees','vendors','users','auth','settings','maintenance'] as $mod)
                    <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>
                        {{ ucfirst($mod) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    @foreach(['created','updated','deleted','assigned','transferred','login','logout'] as $act)
                    <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>
                        {{ ucfirst($act) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-6">
                <input type="text" name="date_from" value="{{ request('date_from') }}"
                       class="form-control form-control-sm datepicker"
                       placeholder="From date">
            </div>
            <div class="col-md-2 col-6">
                <input type="text" name="date_to" value="{{ request('date_to') }}"
                       class="form-control form-control-sm datepicker"
                       placeholder="To date">
            </div>
            <div class="col-md-1 col-6 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('admin.activity-logs.index') }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-clock-rotate-left me-2 text-primary"></i>Activity Log
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    @php
                        $actionColors = [
                            'created'     => 'success',
                            'updated'     => 'primary',
                            'deleted'     => 'danger',
                            'assigned'    => 'info',
                            'transferred' => 'warning',
                            'login'       => 'success',
                            'logout'      => 'secondary',
                            'password_reset' => 'warning',
                        ];
                        $ac = $actionColors[$log->action] ?? 'secondary';
                    @endphp
                    <tr>
                        <td class="text-xs text-muted" style="white-space:nowrap;">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                            <div>{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            @if($log->user)
                            <div class="fw-600 text-sm">{{ $log->user->name }}</div>
                            @else
                            <span class="text-muted text-xs">{{ $log->user_name ?? 'System' }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $ac }} bg-opacity-10 text-{{ $ac }}">
                                {{ ucfirst(str_replace('_',' ',$log->action)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border text-xs">
                                {{ ucfirst($log->module) }}
                            </span>
                        </td>
                        <td class="text-sm fw-500">
                            {{ $log->subject_label ?? '—' }}
                        </td>
                        <td class="text-sm text-muted">
                            {{ Str::limit($log->description, 50) ?? '—' }}
                        </td>
                        <td class="text-xs text-muted">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-history fa-3x opacity-25 d-block mb-3"></i>
                            No activity found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
