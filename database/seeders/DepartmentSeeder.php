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
                'name'    => 'Administration',
                'code'    => 'ADMIN',
                'building'=> 'Main Block',
                'floor'   => 'Ground Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Information Technology',
                'code'    => 'IT',
                'building'=> 'Main Block',
                'floor'   => '1st Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Finance & Accounts',
                'code'    => 'FIN',
                'building'=> 'Main Block',
                'floor'   => '2nd Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Human Resources',
                'code'    => 'HR',
                'building'=> 'Annexe Block',
                'floor'   => 'Ground Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Public Relations',
                'code'    => 'PR',
                'building'=> 'Annexe Block',
                'floor'   => '1st Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Legal Department',
                'code'    => 'LEG',
                'building'=> 'Main Block',
                'floor'   => '3rd Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Planning & Development',
                'code'    => 'PLD',
                'building'=> 'Main Block',
                'floor'   => '3rd Floor',
                'status'  => 'active',
            ],
            [
                'name'    => 'Stores & Purchase',
                'code'    => 'STP',
                'building'=> 'Store Building',
                'floor'   => 'Ground Floor',
                'status'  => 'active',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }

        $this->command->info('✅ Departments seeded: ' . count($departments));
    }
}
