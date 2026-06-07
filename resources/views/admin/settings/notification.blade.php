{{-- resources/views/admin/settings/notification.blade.php --}}
@extends('layouts.app')

@section('title', 'Notification Settings')

@section('breadcrumb')
<span class="bc-sep">/</span>
<a href="{{ route('admin.settings.general') }}">Settings</a>
<span class="bc-sep">/</span>
<span class="bc-current">Notifications</span>
@endsection

@section('page-title', 'Notification Settings')
@section('page-subtitle', 'Configure application notification preferences')

@section('content')
<div class="row g-3">

    {{-- Navigation --}}
    <div class="col-lg-3">
        @include('admin.settings._nav')
    </div>

    {{-- Form --}}
    <div class="col-lg-9">
        <form action="{{ route('admin.settings.notification.update') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bell text-primary"></i>
                    Notification Settings
                </div>

                <div class="card-body">

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               id="email_notifications"
                               name="email_notifications"
                               value="1"
                               {{ ($settings['email_notifications'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_notifications">
                            Enable Email Notifications
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               id="sms_notifications"
                               name="sms_notifications"
                               value="1"
                               {{ ($settings['sms_notifications'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sms_notifications">
                            Enable SMS Notifications
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               id="asset_alerts"
                               name="asset_alerts"
                               value="1"
                               {{ ($settings['asset_alerts'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="asset_alerts">
                            Asset Maintenance Alerts
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               id="stock_alerts"
                               name="stock_alerts"
                               value="1"
                               {{ ($settings['stock_alerts'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="stock_alerts">
                            Low Stock Alerts
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Notification Email
                        </label>
                        <input type="email"
                               name="notification_email"
                               class="form-control"
                               value="{{ $settings['notification_email'] ?? '' }}"
                               placeholder="admin@example.com">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
