<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting GovAsset Manager seed...');
        $this->command->newLine();

        $this->call([
            RolesAndPermissionsSeeder::class,
            DesignationSeeder::class,
            DepartmentSeeder::class,
            SuperAdminSeeder::class,
            SettingsSeeder::class,
            AssetCategorySeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ All seeders completed successfully!');
        $this->command->newLine();
        $this->command->table(
            ['Item', 'Details'],
            [
                ['Login URL',  url('/login')],
                ['Email',      'superadmin@govoffice.gov.in'],
                ['Password',   'Admin@1234'],
                ['Role',       'Super Administrator'],
            ]
        );
    }
}
