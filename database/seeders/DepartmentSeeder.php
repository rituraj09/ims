<?php
// database/seeders/DepartmentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name'    => 'Nazarat',
                'code'    => 'NAZ',
                'building'=> 'DC Office',
                'floor'   => 'First Floor',
                'status'  => 'active',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }

        $this->command->info('✅ Departments seeded: ' . count($departments));
    }
}
