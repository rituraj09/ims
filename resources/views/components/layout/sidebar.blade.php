{{-- resources/views/components/layout/sidebar.blade.php --}}
@php
    $user = auth()->user();
    $isSuperAdmin = $user->isSuperAdmin();
    $isAdmin      = $user->isAdmin();

    // Pre-check all permissions once to avoid repeated DB queries
    $can = [
        'assets_view'       => $isSuperAdmin || $user->hasPermission('assets.view'),
        'assets_create'     => $isSuperAdmin || $user->hasPermission('assets.create'),
        'assets_assign'     => $isSuperAdmin || $user->hasPermission('assets.assign'),
        'categories_view'   => $isSuperAdmin || $user->hasPermission('categories.view'),
        'maintenance_view'  => $isSuperAdmin || $user->hasPermission('maintenance.view'),
        'departments_view'  => $isSuperAdmin || $user->hasPermission('departments.view'),
        'employees_view'    => $isSuperAdmin || $user->hasPermission('employees.view'),
        'vendors_view'      => $isSuperAdmin || $user->hasPermission('vendors.view'),
        'reports_view'      => $isSuperAdmin || $user->hasPermission('reports.view'),
        'users_view'        => $isSuperAdmin || $user->hasPermission('users.view'),
        'roles_manage'      => $isSuperAdmin || $user->hasPermission('roles.manage'),
        'settings_view'     => $isSuperAdmin || $user->hasPermission('settings.view'),
    ];

    // Pending maintenance count
    try {
        $pendMaint = \App\Models\AssetMaintenance::whereIn('status',
            ['scheduled','in_progress'])->count();
    } catch(\Exception $e) {
        $pendMaint = 0;
    }

    // Unread notifications count
    try {
        $unreadNotif = $user->unreadNotifications->count();
    } catch(\Exception $e) {
        $unreadNotif = 0;
    }

    // Active route helpers
    $assetActive  = request()->routeIs('admin.assets.*') ||
                    request()->routeIs('admin.assignments.*');
    $reportActive = request()->routeIs('admin.reports.*');
    $settingActive= request()->routeIs('admin.settings.*');
@endphp

<aside class="sidebar" id="sidebar">

    {{-- ── Brand ── --}}
    <a href="{{ route('dashboard') }}" class="sb-brand">
        <div class="sb-brand-icon">
            <i class="fas fa-landmark"></i>
        </div>
        <span class="sb-brand-text">Gov<em>Asset</em></span>
    </a>

    {{-- ── User Block ── --}}
    <div class="sb-user">
        <img src="{{ $user->profile_photo_url }}"
             alt="{{ $user->name }}"
             class="sb-user-img">
        <div class="sb-user-info">
            <span class="sb-user-name">
                {{ Str::limit($user->name, 22) }}
            </span>
            <span class="sb-user-role">
                {{ $user->role?->display_name ?? 'User' }}
            </span>
        </div>
    </div>

    {{-- ── Scrollable Nav ── --}}
    <nav class="sb-nav" id="sbNav" aria-label="Main Navigation">

        {{-- ════════════════ MAIN ════════════════ --}}
        <div class="sb-section">Main</div>

        <a href="{{ route('dashboard') }}"
           class="sb-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
            <i class="fas fa-chart-pie sb-icon"></i>
            <span class="sb-label">Dashboard</span>
        </a>

        {{-- ════════════════ ASSETS ════════════════ --}}
        @if($can['assets_view'] || $can['categories_view'] || $can['maintenance_view'])
        <div class="sb-section">Asset Management</div>

        {{-- Assets Menu --}}
        @if($can['assets_view'])
        <button type="button"
                class="sb-link {{ $assetActive ? 'active' : '' }}"
                data-bs-toggle="collapse"
                data-bs-target="#navAssets"
                aria-expanded="{{ $assetActive ? 'true' : 'false' }}"
                aria-controls="navAssets">
            <i class="fas fa-boxes-stacked sb-icon"></i>
            <span class="sb-label">Assets</span>
            <i class="fas fa-chevron-right sb-arrow"></i>
        </button>
        <ul class="sb-submenu collapse {{ $assetActive ? 'show' : '' }}"
            id="navAssets">
            <li>
                <a href="{{ route('admin.assets.index') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.index') && !request('status') ? 'active' : '' }}">
                    <span class="sub-dot"></span>All Assets
                </a>
            </li>
            @if($can['assets_create'])
            <li>
                <a href="{{ route('admin.assets.create') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.create') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Add New Asset
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('admin.assets.index', ['status' => 'available']) }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.index') && request('status') === 'available' ? 'active' : '' }}">
                    <span class="sub-dot"></span>
                    Available
                </a>
            </li>
            <li>
                <a href="{{ route('admin.assets.index', ['status' => 'in_use']) }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.index') && request('status') === 'in_use' ? 'active' : '' }}">
                    <span class="sub-dot"></span>
                    In Use
                </a>
            </li>
            <li>
                <a href="{{ route('admin.assets.index', ['status' => 'under_maintenance']) }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.index') && request('status') === 'under_maintenance' ? 'active' : '' }}">
                    <span class="sub-dot"></span>
                    Under Maintenance
                </a>
            </li>
            <li>
                <a href="{{ route('admin.assets.index', ['status' => 'disposed']) }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assets.index') && request('status') === 'disposed' ? 'active' : '' }}">
                    <span class="sub-dot"></span>
                    Disposed
                </a>
            </li>
            @if($can['assets_assign'])
            <li>
                <a href="{{ route('admin.assignments.index') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}">
                    <span class="sub-dot"></span>
                    Assignments
                </a>
            </li>
            @endif
        </ul>
        @endif

        {{-- Categories --}}
        @if($can['categories_view'])
        <a href="{{ route('admin.categories.index') }}"
           class="sb-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags sb-icon"></i>
            <span class="sb-label">Categories</span>
        </a>
        @endif

        {{-- Maintenance --}}
        @if($can['maintenance_view'])
        <a href="{{ route('admin.maintenances.index') }}"
           class="sb-link {{ request()->routeIs('admin.maintenances.*') ? 'active' : '' }}">
            <i class="fas fa-screwdriver-wrench sb-icon"></i>
            <span class="sb-label">Maintenance</span>
            @if($pendMaint > 0)
            <span class="sb-badge bg-warning text-dark">
                {{ $pendMaint > 99 ? '99+' : $pendMaint }}
            </span>
            @endif
        </a>
        @endif

        @endif {{-- end assets section --}}

        {{-- ════════════════ ORGANISATION ════════════════ --}}
        @if($can['departments_view'] || $can['employees_view'] || $can['vendors_view'])
        <div class="sb-section">Organisation</div>

        @if($can['departments_view'])
        <a href="{{ route('admin.departments.index') }}"
           class="sb-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
            <i class="fas fa-building sb-icon"></i>
            <span class="sb-label">Departments</span>
        </a>
        @endif

        @if($can['employees_view'])
        <a href="{{ route('admin.employees.index') }}"
           class="sb-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
            <i class="fas fa-users sb-icon"></i>
            <span class="sb-label">Employees</span>
        </a>
        @endif

        @if($can['vendors_view'])
        <a href="{{ route('admin.vendors.index') }}"
           class="sb-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
            <i class="fas fa-truck sb-icon"></i>
            <span class="sb-label">Vendors</span>
        </a>
        @endif

        @endif {{-- end organisation section --}}

        {{-- ════════════════ REPORTS ════════════════ --}}
        @if($can['reports_view'])
        <div class="sb-section">Reports</div>

        <button type="button"
                class="sb-link {{ $reportActive ? 'active' : '' }}"
                data-bs-toggle="collapse"
                data-bs-target="#navReports"
                aria-expanded="{{ $reportActive ? 'true' : 'false' }}"
                aria-controls="navReports">
            <i class="fas fa-chart-bar sb-icon"></i>
            <span class="sb-label">Reports</span>
            <i class="fas fa-chevron-right sb-arrow"></i>
        </button>
        <ul class="sb-submenu collapse {{ $reportActive ? 'show' : '' }}"
            id="navReports">
            <li>
                <a href="{{ route('admin.reports.assets') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.reports.assets') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Asset Register
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.department') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.reports.department') ? 'active' : '' }}">
                    <span class="sub-dot"></span>By Department
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.depreciation') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.reports.depreciation') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Depreciation
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.warranty') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.reports.warranty') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Warranty Status
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.amc') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.reports.amc') ? 'active' : '' }}">
                    <span class="sub-dot"></span>AMC Status
                </a>
            </li>
        </ul>
        @endif {{-- end reports --}}

        {{-- ════════════════ ADMINISTRATION ════════════════ --}}
        @if($can['users_view'] || $can['roles_manage'] || $can['settings_view'] || $isAdmin)
        <div class="sb-section">Administration</div>

        @if($can['users_view'])
        <a href="{{ route('admin.users.index') }}"
           class="sb-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield sb-icon"></i>
            <span class="sb-label">User Management</span>
        </a>
        @endif

        @if($can['roles_manage'])
        <a href="{{ route('admin.roles.index') }}"
           class="sb-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="fas fa-user-tag sb-icon"></i>
            <span class="sb-label">Roles & Permissions</span>
        </a>
        @endif

        @if($isAdmin)
        <a href="{{ route('admin.designations.index') }}"
           class="sb-link {{ request()->routeIs('admin.designations.*') ? 'active' : '' }}">
            <i class="fas fa-id-badge sb-icon"></i>
            <span class="sb-label">Designations</span>
        </a>
        @endif

        {{-- Settings --}}
        @if($can['settings_view'])
        <button type="button"
                class="sb-link {{ $settingActive ? 'active' : '' }}"
                data-bs-toggle="collapse"
                data-bs-target="#navSettings"
                aria-expanded="{{ $settingActive ? 'true' : 'false' }}"
                aria-controls="navSettings">
            <i class="fas fa-gear sb-icon"></i>
            <span class="sb-label">Settings</span>
            <i class="fas fa-chevron-right sb-arrow"></i>
        </button>
        <ul class="sb-submenu collapse {{ $settingActive ? 'show' : '' }}"
            id="navSettings">
            <li>
                <a href="{{ route('admin.settings.general') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                    <span class="sub-dot"></span>General
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.organisation') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.settings.organisation') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Organisation
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.notification') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.settings.notification') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Notifications
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.backup') }}"
                   class="sb-sub-link {{ request()->routeIs('admin.settings.backup') ? 'active' : '' }}">
                    <span class="sub-dot"></span>Database Backup
                </a>
            </li>
        </ul>
        @endif

        {{-- Activity Log --}}
        @if($isAdmin)
        <a href="{{ route('admin.activity-logs.index') }}"
           class="sb-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i class="fas fa-clock-rotate-left sb-icon"></i>
            <span class="sb-label">Activity Log</span>
        </a>
        @endif

        @endif {{-- end administration --}}

        {{-- ════════════════ ACCOUNT ════════════════ --}}
        <div class="sb-section">Account</div>

        <a href="{{ route('profile.show') }}"
           class="sb-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
            <i class="fas fa-circle-user sb-icon"></i>
            <span class="sb-label">My Profile</span>
        </a>

        <a href="{{ route('profile.password') }}"
           class="sb-link {{ request()->routeIs('profile.password') ? 'active' : '' }}">
            <i class="fas fa-key sb-icon"></i>
            <span class="sb-label">Change Password</span>
        </a>

        {{-- Logout --}}
        <div style="margin: 6px 8px 0;">
            <form action="{{ route('logout') }}" method="POST" id="sidebarLogoutForm">
                @csrf
                <button type="button"
                        onclick="document.getElementById('sidebarLogoutForm').submit()"
                        class="sb-link w-100"
                        style="color:#f87171;">
                    <i class="fas fa-right-from-bracket sb-icon" style="color:#f87171;"></i>
                    <span class="sb-label">Logout</span>
                </button>
            </form>
        </div>

    </nav>

    {{-- ── Footer ── --}}
    <div class="sb-footer">
        <i class="fas fa-code me-1"></i>
        v1.0.0 &bull; PHP {{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}
    </div>

</aside>
