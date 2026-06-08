<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with(['role', 'department', 'designation'])
            ->when($request->search, fn($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('employee_id', 'like', "%{$request->search}%"))
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->when($request->status,  fn($q) => $q->where('status', $request->status))
            ->when($request->department_id, fn($q) => $q->where('department_id', $request->department_id))
            ->orderBy('id')->paginate(25)->withQueryString();

        $roles       = Role::all();
        $departments = Department::active()->get();

        return view('admin.users.index', compact('users', 'roles', 'departments'));
    }

    public function create(): View
    {
        $roles        = Role::all();
        $departments  = Department::active()->get();
        $designations = Designation::active()->ordered()->get();

        return view('admin.users.create', compact('roles', 'departments', 'designations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'email'          => ['required', 'email', 'max:150', 'unique:users,email'],
            'employee_id'    => ['nullable', 'string', 'max:50', 'unique:users,employee_id'],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'gender'         => ['nullable', 'in:male,female,other'],
            'role_id'        => ['required', 'exists:roles,id'],
            'department_id'  => ['nullable', 'exists:departments,id'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'password'       => ['required', 'min:8', 'confirmed'],
            'status'         => ['required', 'in:active,inactive'],
            'joining_date'   => ['nullable', 'date'],
        ]);

        $validated['password']       = Hash::make($validated['password']);
        $validated['is_system_user'] = true;

        $user = User::create($validated);

        ActivityLog::log('created', 'users', $user);

        return redirect()->route('admin.users.index')
            ->with('success', "User '{$user->name}' created successfully.");
    }

    public function show(User $user): View
    {
        $user->load(['role', 'department', 'designation', 'assignedAssets.category']);
        $recentLogs = ActivityLog::where('user_id', $user->id)->latest()->take(10)->get();

        return view('admin.users.show', compact('user', 'recentLogs'));
    }

    public function edit(User $user): View
    {
        if (
            $user->isSuperAdmin() &&
            !auth()->user()->isSuperAdmin()
        ) {
            abort(403, 'You cannot edit a Super Admin.');
        }

        $roles        = Role::all();
        $departments  = Department::active()->get();
        $designations = Designation::active()->ordered()->get();

        return view('admin.users.edit', compact(
            'user',
            'roles',
            'departments',
            'designations'
        ));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (
            $user->isSuperAdmin() &&
            !auth()->user()->isSuperAdmin()
        ) {
            return back()->with(
                'error',
                'You cannot modify a Super Admin account.'
            );
        }
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:150'],
            'email'          => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
            'employee_id'    => ['nullable', 'string', 'max:50', 'unique:users,employee_id,' . $user->id],
            'mobile'         => ['nullable', 'string', 'max:15'],
            'gender'         => ['nullable', 'in:male,female,other'],
            'role_id'        => ['required', 'exists:roles,id'],
            'department_id'  => ['nullable', 'exists:departments,id'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'status'         => ['required', 'in:active,inactive'],
            'joining_date'   => ['nullable', 'date'],
        ]);

        // Prevent super admin from deactivating themselves
        if ($user->id === auth()->id() && $validated['status'] === 'inactive') {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update($validated);
        ActivityLog::log('updated', 'users', $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->assignedAssets()->count() > 0) {
            return back()->with('error', 'User has assigned assets. Please reassign first.');
        }

        ActivityLog::log('deleted', 'users', $user);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return back()->with(
                'error',
                'Super Admin status cannot be changed.'
            );
        }
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);

        return back()->with('success', "User status updated to {$user->status}.");
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        ActivityLog::log('password_reset', 'users', $user,
            description: "Password reset by admin: " . auth()->user()->name);

        return back()->with('success', 'Password reset successfully.');
    }
}
