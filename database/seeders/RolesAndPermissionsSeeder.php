<?php
// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Permissions ───────────────────────────────────────────────────

        $permissions = [
            // Assets
            ['name' => 'assets.view',     'display_name' => 'View Assets',     'module' => 'assets'],
            ['name' => 'assets.create',   'display_name' => 'Create Assets',   'module' => 'assets'],
            ['name' => 'assets.edit',     'display_name' => 'Edit Assets',     'module' => 'assets'],
            ['name' => 'assets.delete',   'display_name' => 'Delete Assets',   'module' => 'assets'],
            ['name' => 'assets.assign',   'display_name' => 'Assign Assets',   'module' => 'assets'],
            ['name' => 'assets.transfer', 'display_name' => 'Transfer Assets', 'module' => 'assets'],
            ['name' => 'assets.dispose',  'display_name' => 'Dispose Assets',  'module' => 'assets'],
            ['name' => 'assets.export',   'display_name' => 'Export Assets',   'module' => 'assets'],

            // Categories
            ['name' => 'categories.view',   'display_name' => 'View Categories',   'module' => 'categories'],
            ['name' => 'categories.create', 'display_name' => 'Create Categories', 'module' => 'categories'],
            ['name' => 'categories.edit',   'display_name' => 'Edit Categories',   'module' => 'categories'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Categories', 'module' => 'categories'],

            // Departments
            ['name' => 'departments.view',   'display_name' => 'View Departments',   'module' => 'departments'],
            ['name' => 'departments.create', 'display_name' => 'Create Departments', 'module' => 'departments'],
            ['name' => 'departments.edit',   'display_name' => 'Edit Departments',   'module' => 'departments'],
            ['name' => 'departments.delete', 'display_name' => 'Delete Departments', 'module' => 'departments'],

            // Employees
            ['name' => 'employees.view',   'display_name' => 'View Employees',   'module' => 'employees'],
            ['name' => 'employees.create', 'display_name' => 'Create Employees', 'module' => 'employees'],
            ['name' => 'employees.edit',   'display_name' => 'Edit Employees',   'module' => 'employees'],
            ['name' => 'employees.delete', 'display_name' => 'Delete Employees', 'module' => 'employees'],

            // Vendors
            ['name' => 'vendors.view',   'display_name' => 'View Vendors',   'module' => 'vendors'],
            ['name' => 'vendors.create', 'display_name' => 'Create Vendors', 'module' => 'vendors'],
            ['name' => 'vendors.edit',   'display_name' => 'Edit Vendors',   'module' => 'vendors'],
            ['name' => 'vendors.delete', 'display_name' => 'Delete Vendors', 'module' => 'vendors'],

            // Maintenance
            ['name' => 'maintenance.view',   'display_name' => 'View Maintenance',   'module' => 'maintenance'],
            ['name' => 'maintenance.create', 'display_name' => 'Create Maintenance', 'module' => 'maintenance'],
            ['name' => 'maintenance.edit',   'display_name' => 'Edit Maintenance',   'module' => 'maintenance'],
            ['name' => 'maintenance.delete', 'display_name' => 'Delete Maintenance', 'module' => 'maintenance'],

            // Reports
            ['name' => 'reports.view',   'display_name' => 'View Reports',   'module' => 'reports'],
            ['name' => 'reports.export', 'display_name' => 'Export Reports', 'module' => 'reports'],

            // Settings
            ['name' => 'settings.view',   'display_name' => 'View Settings',   'module' => 'settings'],
            ['name' => 'settings.manage', 'display_name' => 'Manage Settings', 'module' => 'settings'],

            // User Management
            ['name' => 'users.view',   'display_name' => 'View Users',   'module' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'users.edit',   'display_name' => 'Edit Users',   'module' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'users'],
            ['name' => 'roles.manage', 'display_name' => 'Manage Roles & Permissions', 'module' => 'users'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        // ── Roles ─────────────────────────────────────────────────────────

        $allPermissions = Permission::pluck('id')->toArray();

        // Super Admin - All permissions
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name'   => 'Super Administrator',
                'description'    => 'Full system access',
                'is_system_role' => true,
            ]
        );
        $superAdmin->permissions()->sync($allPermissions);

        // Admin - All except settings.manage and roles.manage
        $adminPermissions = Permission::whereNotIn('name', [
            'roles.manage',
        ])->pluck('id')->toArray();

        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name'   => 'Administrator',
                'description'    => 'Administrative access',
                'is_system_role' => true,
            ]
        );
        $admin->permissions()->sync($adminPermissions);

        // Author - View + Create + Edit (no delete/settings/users)
        $authorPermissions = Permission::where('name', 'like', '%.view')
            ->orWhere('name', 'like', '%.create')
            ->orWhere('name', 'like', '%.edit')
            ->whereNotIn('name', [
                'settings.manage',
                'roles.manage',
                'users.create',
                'users.edit',
                'users.delete',
            ])
            ->pluck('id')->toArray();

        $author = Role::firstOrCreate(
            ['name' => 'author'],
            [
                'display_name'   => 'Author',
                'description'    => 'Can create and edit records',
                'is_system_role' => true,
            ]
        );
        $author->permissions()->sync($authorPermissions);

        // User - View only
        $userPermissions = Permission::where('name', 'like', '%.view')
            ->pluck('id')->toArray();

        $user = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name'   => 'User',
                'description'    => 'Read-only access',
                'is_system_role' => true,
            ]
        );
        $user->permissions()->sync($userPermissions);

        $this->command->info('✅ Roles and Permissions seeded successfully.');
    }
}
