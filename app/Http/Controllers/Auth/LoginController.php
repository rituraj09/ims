<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
   public function login(Request $request): RedirectResponse
{
    $request->validate([
        'login'    => ['required', 'string'],
        'password' => ['required', 'string'],
    ], [
        'login.required'    => 'Email Address or Mobile Number is required.',
        'password.required' => 'Password is required.',
    ]);

    // Rate Limiting
    $throttleKey = Str::lower($request->input('login'))
                    . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'login' => "Too many login attempts. Please wait {$seconds} seconds.",
        ]);
    }

    $login = trim($request->login);

    // Determine login field
    $field = filter_var($login, FILTER_VALIDATE_EMAIL)
        ? 'email'
        : 'mobile';

    $credentials = [
        $field => $login,
        'password' => $request->password,
    ];

    $remember = $request->boolean('remember');

    if (!Auth::attempt($credentials, $remember)) {

        RateLimiter::hit($throttleKey, 60);

        throw ValidationException::withMessages([
            'login' => 'The provided credentials are incorrect.',
        ]);
    }

    RateLimiter::clear($throttleKey);

    $user = Auth::user();

    // System User Check
    if (!$user->is_system_user) {

        Auth::logout();

        throw ValidationException::withMessages([
            'login' => 'You do not have system login access. Contact administrator.',
        ]);
    }

    // Status Check
    if ($user->status !== 'active') {

        Auth::logout();

        throw ValidationException::withMessages([
            'login' => 'Your account is inactive. Contact administrator.',
        ]);
    }

    $request->session()->regenerate();

    try {
        ActivityLog::log(
            action      : 'login',
            module      : 'auth',
            description : "Logged in from IP: {$request->ip()}"
        );
    } catch (\Exception $e) {
        //
    }

    return redirect()
        ->intended(route('dashboard'))
        ->with('success', "Welcome back, {$user->name}!");
}

    /**
     * Handle logout
     */
    public function logout(Request $request): RedirectResponse
    {
        // Log before logout
        try {
            ActivityLog::log('logout', 'auth');
        } catch (\Exception $e) {
            //
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
               ->with('success', 'You have been logged out successfully.');
    }
}
