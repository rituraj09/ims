<?php
// database/seeders/SuperAdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'employee_id'    => 'SA-0001',
                'name'           => 'Super Administrator',
                'mobile'         => '9000000000',
                'gender'         => 'male',
                'role_id'        => $superAdminRole->id,
                'is_system_user' => true,
                'status'         => 'active',
                'password'       => bcrypt('123456'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super Admin created: superadmin@govoffice.gov.in / Admin@1234');
    }
}
