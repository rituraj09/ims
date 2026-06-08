@extends('layouts.auth')

@section('title', 'Login')

@section('auth-content')

<div class="auth-form-header">
    <h3 class="auth-form-title">Welcome Back</h3>
    <p class="auth-form-subtitle">
        Sign in to your account to continue
    </p>
</div>

<form method="POST"
      action="{{ route('login') }}"
      class="auth-form"
      id="loginForm">

    @csrf

    {{-- Email / Mobile --}}
    <div class="form-floating mb-3">
        <input type="text"
               class="form-control @error('login') is-invalid @enderror"
               id="login"
               name="login"
               value="{{ old('login') }}"
               placeholder="Email Address or Mobile Number"
               required
               autofocus>

        <label for="login">
            <i class="fas fa-user me-1"></i>
            Email Address or Mobile Number
        </label>

        @error('login')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="form-floating mb-3 position-relative">
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               id="password"
               name="password"
               placeholder="Password"
               required>

        <label for="password">
            <i class="fas fa-lock me-1"></i>
            Password
        </label>

        <button type="button"
                class="btn-password-toggle"
                id="passwordToggle"
                tabindex="-1">
            <i class="fas fa-eye"
               id="passwordToggleIcon"></i>
        </button>

        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    {{-- Remember --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   id="remember"
                   name="remember"
                   {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label"
                   for="remember">
                Remember Me
            </label>
        </div>

        @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="text-primary small">
                Forgot Password?
            </a>
        @endif

    </div>

    {{-- Submit --}}
    <button type="submit"
            class="btn btn-primary btn-lg w-100 auth-submit-btn"
            id="loginBtn">

        <span class="btn-text">
            <i class="fas fa-sign-in-alt me-2"></i>
            Sign In
        </span>

        <span class="btn-loading d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>
            Signing In...
        </span>

    </button>

    <div class="auth-notice mt-4">
        <i class="fas fa-info-circle me-1"></i>
        This is a restricted government system.
        Unauthorized access is prohibited.
    </div>

</form>

@endsection

@push('scripts')
<script>
document.getElementById('passwordToggle').addEventListener('click', function () {

    let password = document.getElementById('password');
    let icon = document.getElementById('passwordToggleIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('loginForm').addEventListener('submit', function () {

    let btn = document.getElementById('loginBtn');

    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');

    btn.disabled = true;
});
</script>
@endpush
