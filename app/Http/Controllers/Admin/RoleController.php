<?php
// app/Http/Controllers/Admin/RoleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount(['permissions', 'users'])->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function permissions(Role $role): View
    {
        $role->load('permissions');
        $permissions = Permission::orderBy('module')->orderBy('name')->get()
            ->groupBy('module');

        return view('admin.roles.permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role): RedirectResponse
    {
        if ($role->is_system_role && $role->name === 'super_admin') {
            return back()->with('error', 'Super Admin permissions cannot be modified.');
        }

        $permissionIds = Permission::whereIn('name', $request->permissions ?? [])
            ->pluck('id')->toArray();

        $role->permissions()->sync($permissionIds);

        ActivityLog::log('updated', 'roles', $role,
            description: "Permissions updated for role: {$role->name}");

        // Clear permission cache
        app()[\Illuminate\Contracts\Auth\Access\Gate::class]->clearResolvedInstances();

        return back()->with('success', "Permissions updated for {$role->display_name}.");
    }
}
