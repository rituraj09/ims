{{-- resources/views/components/layout/header.blade.php --}}
@props(['title' => '', 'subtitle' => ''])

<header class="topbar">

    {{-- Left Side --}}
    <div class="topbar-left">

        {{-- Sidebar Toggle --}}
        <button type="button" class="toggle-btn" id="sbToggle" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Breadcrumb --}}
        <nav class="topbar-bc d-none d-md-flex" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" title="Dashboard">
                <i class="fas fa-house" style="font-size:13px;"></i>
            </a>
            {{ $slot }}
        </nav>

    </div>

    {{-- Right Side --}}
    <div class="topbar-right">

        {{-- Add Asset Quick Button --}}
        @can('assets.create')
        <a href="{{ route('admin.assets.create') }}"
           class="btn btn-primary btn-sm d-none d-sm-inline-flex">
            <i class="fas fa-plus"></i>
            <span>Add Asset</span>
        </a>
        @endcan

        {{-- Notifications --}}
        <div class="dropdown">
            <button type="button"
                    class="tb-btn"
                    id="notifDropdown"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    aria-label="Notifications">
                <i class="fas fa-bell"></i>
                @php
                    try {
                        $unreadCount = auth()->user()->unreadNotifications->count();
                    } catch(\Exception $e) { $unreadCount = 0; }
                @endphp
                @if($unreadCount > 0)
                <span class="tb-notif-count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end notif-dropdown"
                 aria-labelledby="notifDropdown">
                <div class="notif-dd-head">
                    <strong>Notifications</strong>
                    @if($unreadCount > 0)
                    <a href="{{ route('admin.notifications.markAllRead') }}"
                       class="text-primary">Mark all read</a>
                    @endif
                </div>

                <div class="notif-dd-body">
                    @php
                        try {
                            $notifications = auth()->user()->unreadNotifications->take(6);
                        } catch(\Exception $e) { $notifications = collect(); }
                    @endphp

                    @forelse($notifications as $notif)
                    <div class="notif-item unread" data-id="{{ $notif->id }}">
                        <div class="notif-ico bg-{{ $notif->data['color'] ?? 'primary' }}">
                            <i class="{{ $notif->data['icon'] ?? 'fas fa-bell' }}"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="notif-title">{{ $notif->data['title'] ?? 'Notification' }}</div>
                            <div class="notif-msg">{{ Str::limit($notif->data['message'] ?? '', 55) }}</div>
                            <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-bell-slash fa-2x d-block mb-2" style="opacity:.2;"></i>
                        <span style="font-size:12.5px;">No new notifications</span>
                    </div>
                    @endforelse
                </div>

                <div class="notif-dd-foot">
                    <a href="{{ route('admin.notifications.index') }}">
                        View All Notifications
                        @if($unreadCount > 0)
                        <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        {{-- User Dropdown --}}
        <div class="dropdown">
            <button type="button"
                    class="tb-user-btn"
                    id="userDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff&size=56&bold=true"
                     alt="{{ auth()->user()->name }}"
                     class="tb-user-img">
                <div class="tb-user-text d-none d-md-block">
                    <span class="tb-user-name">{{ Str::limit(auth()->user()->name, 16) }}</span>
                    <span class="tb-user-role">
                        {{ auth()->user()->role?->display_name ?? 'User' }}
                    </span>
                </div>
                <i class="fas fa-chevron-down text-muted d-none d-md-inline"
                   style="font-size:9px;margin-left:2px;"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end tb-dropdown"
                aria-labelledby="userDropdown">
                <li>
                    <div class="tb-dd-header">Signed in as</div>
                </li>
                <li>
                    <span class="dropdown-item-text px-3 py-1">
                        <strong style="font-size:13px;">{{ auth()->user()->name }}</strong>
                        @if(auth()->user()->email)
                        <br>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                        @endif
                    </span>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-circle-user text-primary"></i>
                        My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.password') }}">
                        <i class="fas fa-key text-warning"></i>
                        Change Password
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.general') }}">
                        <i class="fas fa-gear text-secondary"></i>
                        System Settings
                    </a>
                </li>
                @endif
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</header>
