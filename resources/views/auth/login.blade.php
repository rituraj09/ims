{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.auth')
@section('title', 'Login')

@section('auth-content')
<div class="auth-form-header">
    <h3 class="auth-form-title">Welcome Back</h3>
    <p class="auth-form-subtitle">Sign in to your account to continue</p>
</div>

<form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
    @csrf

    {{-- Email --}}
    <div class="form-floating mb-3">
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               id="email" name="email"
               value="{{ old('email') }}"
               placeholder="Email Address"
               required autofocus autocomplete="email">
        <label for="email">
            <i class="fas fa-envelope me-1"></i> Email Address
        </label>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="form-floating mb-3 position-relative">
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               id="password" name="password"
               placeholder="Password"
               required autocomplete="current-password">
        <label for="password">
            <i class="fas fa-lock me-1"></i> Password
        </label>
        <button type="button" class="btn-password-toggle" id="passwordToggle"
                tabindex="-1">
            <i class="fas fa-eye" id="passwordToggleIcon"></i>
        </button>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Remember Me --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   name="remember" id="remember"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>
        @if(Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-primary small">
            Forgot Password?
        </a>
        @endif
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-primary btn-lg w-100 auth-submit-btn"
            id="loginBtn">
        <span class="btn-text">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </span>
        <span class="btn-loading d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>
            Signing In...
        </span>
    </button>

    {{-- System Notice --}}
    <div class="auth-notice mt-4">
        <i class="fas fa-info-circle me-1"></i>
        This is a restricted government system. Unauthorized access is prohibited.
    </div>
</form>
@endsection

@push('scripts')
<script>
// Password Toggle
document.getElementById('passwordToggle').addEventListener('click', function() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('passwordToggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

// Submit Loading State
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('loginBtn');
    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');
    btn.disabled = true;
});
</script>
@endpush
