{{-- resources/views/admin/settings/_nav.blade.php --}}
<div class="card">
    <div class="card-body p-2">
        <nav class="nav flex-column gap-1">
            @php
                $settingNavs = [
                    ['route' => 'admin.settings.general',     'icon' => 'fas fa-sliders-h',  'label' => 'General'],
                    ['route' => 'admin.settings.organisation', 'icon' => 'fas fa-landmark',   'label' => 'Organisation'],
                    ['route' => 'admin.settings.notification', 'icon' => 'fas fa-bell',       'label' => 'Notifications'],
                    ['route' => 'admin.settings.backup',       'icon' => 'fas fa-database',   'label' => 'Database Backup'],
                ];
            @endphp
            @foreach($settingNavs as $nav)
            <a href="{{ route($nav['route']) }}"
               class="nav-link rounded-2 px-3 py-2 d-flex align-items-center gap-2
                      {{ request()->routeIs($nav['route']) ? 'active bg-primary text-white' : 'text-dark' }}"
               style="font-size:13px;font-weight:500;">
                <i class="{{ $nav['icon'] }} fa-fw"></i>
                {{ $nav['label'] }}
            </a>
            @endforeach
        </nav>
    </div>
</div>
