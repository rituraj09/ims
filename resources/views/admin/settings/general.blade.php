{{-- resources/views/admin/settings/general.blade.php --}}
@extends('layouts.app')
@section('title', 'General Settings')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.settings.general') }}">Settings</a>
<span class="bc-sep">/</span>
<span class="bc-current">General</span>
@endsection

@section('page-title', 'General Settings')
@section('page-subtitle', 'Configure basic application settings')

@section('content')
<div class="row g-3">

    {{-- Settings Navigation --}}
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body p-2">
                <nav class="nav flex-column gap-1">
                    @php
                        $settingNavs = [
                            ['route' => 'admin.settings.general',      'icon' => 'fas fa-sliders-h',  'label' => 'General'],
                            ['route' => 'admin.settings.organisation',  'icon' => 'fas fa-landmark',   'label' => 'Organisation'],
                            ['route' => 'admin.settings.notification',  'icon' => 'fas fa-bell',       'label' => 'Notifications'],
                            ['route' => 'admin.settings.backup',        'icon' => 'fas fa-database',   'label' => 'Database Backup'],
                        ];
                    @endphp
                    @foreach($settingNavs as $nav)
                    <a href="{{ route($nav['route']) }}"
                       class="nav-link rounded-2 px-3 py-2 d-flex align-items-center gap-2
                              {{ request()->routeIs($nav['route']) ? 'active bg-primary text-white' : 'text-dark' }}">
                        <i class="{{ $nav['icon'] }} fa-fw"></i>
                        {{ $nav['label'] }}
                    </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <div class="col-lg-9">
        <form action="{{ route('admin.settings.general.update') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-sliders-h text-primary"></i> Application Settings
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Application Name <span class="text-danger">*</span></label>
                        <input type="text" name="app_name"
                               class="form-control"
                               value="{{ $settings['app_name'] ?? 'GovAsset Manager' }}"
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Timezone</label>
                        <select name="app_timezone" class="form-select select2">
                            @php
                                $timezones = DateTimeZone::listIdentifiers();
                            @endphp
                            @foreach($timezones as $tz)
                            <option value="{{ $tz }}"
                                {{ ($settings['app_timezone'] ?? 'Asia/Kolkata') === $tz ? 'selected' : '' }}>
                                {{ $tz }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date Format</label>
                        <select name="date_format" class="form-select">
                            @php
                                $formats = [
                                    'd/m/Y' => date('d/m/Y') . ' (dd/mm/yyyy)',
                                    'm/d/Y' => date('m/d/Y') . ' (mm/dd/yyyy)',
                                    'Y-m-d' => date('Y-m-d') . ' (yyyy-mm-dd)',
                                    'd-m-Y' => date('d-m-Y') . ' (dd-mm-yyyy)',
                                    'd M Y' => date('d M Y') . ' (dd Mon yyyy)',
                                ];
                            @endphp
                            @foreach($formats as $format => $label)
                            <option value="{{ $format }}"
                                {{ ($settings['date_format'] ?? 'd/m/Y') === $format ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol"
                               class="form-control"
                               value="{{ $settings['currency_symbol'] ?? '₹' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Items Per Page</label>
                        <select name="items_per_page" class="form-select">
                            @foreach([10, 15, 25, 50, 100] as $count)
                            <option value="{{ $count }}"
                                {{ ($settings['items_per_page'] ?? 25) == $count ? 'selected' : '' }}>
                                {{ $count }} items
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-barcode text-primary"></i> Asset Tag Settings
            </div>
            <div class="card-body">
                @php $assetTagSettings = \App\Models\Setting::getGroup('asset_tag'); @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tag Format</label>
                        <input type="text" name="asset_tag_format"
                               class="form-control"
                               value="{{ $assetTagSettings['format'] ?? '{ORG_CODE}-{CAT_CODE}-{YEAR}-{SEQ}' }}">
                        <div class="form-text">
                            Placeholders: <code>{ORG_CODE}</code> <code>{CAT_CODE}</code>
                            <code>{YEAR}</code> <code>{YEAR2}</code>
                            <code>{MONTH}</code> <code>{SEQ}</code>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Organisation Code</label>
                        <input type="text" name="asset_tag_org_code"
                               class="form-control"
                               value="{{ $assetTagSettings['org_code'] ?? 'GOV' }}"
                               style="text-transform:uppercase;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sequence Digits</label>
                        <select name="asset_tag_seq_digits" class="form-select">
                            @foreach([3, 4, 5, 6] as $d)
                            <option value="{{ $d }}"
                                {{ ($assetTagSettings['seq_digits'] ?? 4) == $d ? 'selected' : '' }}>
                                {{ $d }} digits
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info py-2 mb-0 text-sm">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Preview:</strong>
                            <code id="tagPreview">GOV-IT-2024-0001</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>

        </form>
    </div>
</div>
@endsection
