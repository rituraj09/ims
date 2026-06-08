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

            // Activity Logs
            ['name' => 'activity-logs', 'display_name' => 'View Activity Logs', 'module' => 'activity-logs'],

            // User Management
            ['name' => 'users.view',   'display_name' => 'View Users',   'module' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'users.edit',   'display_name' => 'Edit Users',   'module' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'users'],
            ['name' => 'roles.manage', 'display_name' => 'Manage Roles & Permissions', 'module' => 'users'],

            // ── IP Management ─────────────────────────────────
            // FIX: was using 'group' key instead of 'module' key
            ['name' => 'ip.view',   'display_name' => 'View IP Addresses',       'module' => 'ip'],
            ['name' => 'ip.manage', 'display_name' => 'Manage IP & Allocations', 'module' => 'ip'],
        ];

        // ── Upsert permissions safely ──────────────────────────────────────
        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name']],  // search key
                [                           // values to set/update
                    'display_name' => $perm['display_name'],
                    'module'       => $perm['module'],
                ]
            );
        }

        // ── Roles ─────────────────────────────────────────────────────────

        $allPermissions = Permission::pluck('id')->toArray();

        // ── Super Admin — everything ───────────────────────────────────────
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name'   => 'Super Administrator',
                'description'    => 'Full system access',
                'is_system_role' => true,
            ]
        );
        $superAdmin->permissions()->sync($allPermissions);

        // ── Admin — all except roles.manage ───────────────────────────────
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


        // IT Admin
        $itadmin = Role::firstOrCreate(
            ['name' => 'IT admin'],
            [
                'display_name'   => 'IT Administrator',
                'description'    => 'IT Administrative access',
                'is_system_role' => true,
            ]
        );
        $itadmin->permissions()->sync($adminPermissions);
        //--end IT Admin

        // ── Author — view + create + edit, guarded exclusions ─────────────
        // FIX: original query had broken orWhere + whereNotIn scoping.
        // Correct approach: use a grouped where closure.
        $excludedFromAuthor = [
            'settings.manage',
            'roles.manage',
            'users.create',
            'users.edit',
            'users.delete',
            'assets.delete',
            'categories.delete',
            'departments.delete',
            'employees.delete',
            'vendors.delete',
            'maintenance.delete',
            'ip.manage',        // allocations management — author shouldn't have this
        ];

        $authorPermissions = Permission::where(function ($query) {
                                    // FIX: group the OR conditions inside a closure
                                    // so whereNotIn applies to BOTH conditions
                                    $query->where('name', 'like', '%.view')
                                          ->orWhere('name', 'like', '%.create')
                                          ->orWhere('name', 'like', '%.edit');
                                })
                                ->whereNotIn('name', $excludedFromAuthor)
                                ->pluck('id')
                                ->toArray();

        $author = Role::firstOrCreate(
            ['name' => 'author'],
            [
                'display_name'   => 'Author',
                'description'    => 'Can create and edit records',
                'is_system_role' => true,
            ]
        );
        $author->permissions()->sync($authorPermissions);

        // ── User — view only ──────────────────────────────────────────────
        $userPermissions = Permission::where('name', 'like', '%.view')
            ->pluck('id')
            ->toArray();

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name'   => 'User',
                'description'    => 'Read-only access',
                'is_system_role' => true,
            ]
        );
        $userRole->permissions()->sync($userPermissions);

        $this->command->info('✅ Roles and Permissions seeded successfully.');
        $this->command->table(
            ['Role', 'Permissions Count'],
            [
                ['Super Admin', count($allPermissions)],
                ['Admin',       count($adminPermissions)],
                ['IT Admin',       count($adminPermissions)],
                ['Author',      count($authorPermissions)],
                ['User',        count($userPermissions)],
            ]
        );
    }
}
