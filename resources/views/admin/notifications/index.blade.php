{{-- resources/views/admin/notifications/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Notifications')

@section('breadcrumb')
    <span class="bc-sep">/</span>
    <span class="bc-current">Notifications</span>
@endsection

@section('page-title', 'Notifications')

@section('page-actions')
    <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-check-double"></i> Mark All Read
        </button>
    </form>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            @forelse($notifications as $notif)
                <div class="d-flex gap-3 p-3 border-bottom {{ is_null($notif->read_at) ? '' : 'bg-light' }}"
                    style="{{ is_null($notif->read_at) ? 'background:#eff6ff;' : '' }}">
                    <div
                        style="width:40px;height:40px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;font-size:15px;">
                        <i class="{{ $notif->data['icon'] ?? 'fas fa-bell' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-600 text-sm">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                <div class="text-muted text-sm mt-1">{{ $notif->data['message'] ?? '' }}</div>
                            </div>
                            <div class="text-xs text-muted flex-shrink-0 ms-3">
                                {{ $notif->created_at->diffForHumans() }}
                                @if (is_null($notif->read_at))
                                    <span class="badge bg-primary ms-1">New</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-bell-slash fa-3x opacity-25 d-block mb-3"></i>
                    No notifications found
                </div>
            @endforelse
        </div>
        @if ($notifications->hasPages())
            <div class="card-footer">{{ $notifications->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
