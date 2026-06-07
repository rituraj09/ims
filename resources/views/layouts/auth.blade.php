{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') | {{ setting('general.app_name', 'GovAsset') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body class="auth-body">

<div class="auth-wrapper">
    {{-- Left Panel --}}
    <div class="auth-left d-none d-lg-flex">
        <div class="auth-left-content">
            <div class="auth-logo mb-4">
                @if(setting('organisation.org_logo'))
                    <img src="{{ asset('storage/'.setting('organisation.org_logo')) }}"
                         alt="Logo" style="max-height:80px;">
                @else
                    <div class="auth-logo-icon">
                        <i class="fas fa-landmark fa-3x"></i>
                    </div>
                @endif
            </div>
            <h2 class="auth-left-title">
                {{ setting('general.app_name', 'GovAsset Manager') }}
            </h2>
            <p class="auth-left-subtitle">
                Government Asset Management System
            </p>
            <div class="auth-features">
                <div class="auth-feature-item">
                    <i class="fas fa-boxes-stacked"></i>
                    <span>Complete Asset Inventory</span>
                </div>
                <div class="auth-feature-item">
                    <i class="fas fa-file-signature"></i>
                    <span>Handover & Takeover Forms</span>
                </div>
                <div class="auth-feature-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Depreciation Tracking</span>
                </div>
                <div class="auth-feature-item">
                    <i class="fas fa-shield-halved"></i>
                    <span>Role-Based Access Control</span>
                </div>
            </div>
            <div class="auth-org-name">
                {{ setting('organisation.org_name', '') }}
            </div>
        </div>
        {{-- Decorative Circles --}}
        <div class="auth-circle auth-circle-1"></div>
        <div class="auth-circle auth-circle-2"></div>
        <div class="auth-circle auth-circle-3"></div>
    </div>

    {{-- Right Panel (Form) --}}
    <div class="auth-right">
        <div class="auth-form-container">
            {{-- Mobile Logo --}}
            <div class="text-center mb-4 d-lg-none">
                <div class="auth-logo-icon-sm">
                    <i class="fas fa-landmark fa-2x text-primary"></i>
                </div>
                <h5 class="mt-2 fw-bold text-primary">
                    {{ setting('general.app_name', 'GovAsset') }}
                </h5>
            </div>

            @yield('auth-content')

            <div class="auth-footer">
                &copy; {{ date('Y') }}
                {{ setting('organisation.org_name', 'Government Office') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
@stack('scripts')
</body>
</html>
