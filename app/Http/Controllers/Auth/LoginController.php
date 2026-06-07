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
        // Validate input
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        // Rate Limiting - max 5 attempts per minute
        $throttleKey = Str::lower($request->input('email'))
                     . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please wait {$seconds} seconds.",
            ]);
        }

        // Attempt authentication
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        // Clear rate limiter on success
        RateLimiter::clear($throttleKey);

        $user = Auth::user();

        // Check system user access
        if (!$user->is_system_user) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'You do not have system login access. Contact administrator.',
            ]);
        }

        // Check account status
        if ($user->status !== 'active') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account is inactive. Contact administrator.',
            ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        // Log activity safely
        try {
            ActivityLog::log(
                action      : 'login',
                module      : 'auth',
                description : "Logged in from IP: {$request->ip()}"
            );
        } catch (\Exception $e) {
            // Don't block login if logging fails
        }

        return redirect()->intended(route('dashboard'))
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
