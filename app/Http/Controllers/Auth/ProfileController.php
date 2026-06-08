<?php
// app/Http/Controllers/Auth/ProfileController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user()->load('designation', 'department', 'role');
        return view('profile.show', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $request->validate([
            'name'   => ['required', 'string', 'max:150'],
            'mobile' => ['nullable', 'string', 'max:15'],
            'gender' => ['nullable', 'in:male,female,other'],
        ]);

        $user->update($request->only('name', 'mobile', 'gender'));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function password(): View
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        // delete old photo
        if ($user->profile_photo &&
            Storage::disk('public')->exists($user->profile_photo)) {

            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('photo')
            ->store('profile-photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        return back()->with(
            'success',
            'Profile photo updated successfully.'
        );
    }
}
