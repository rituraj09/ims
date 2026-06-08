<?php
// database/seeders/DesignationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;
use Illuminate\Support\Str;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = [
            ['name' => 'District Commissioner', 'order' => 1],
            ['name' => 'District Development Commissioner', 'order' => 2],
            ['name' => 'Addl. District Commissioner', 'order' => 3],
            ['name' => 'Asstt. Commissioner', 'order' => 4],
            ['name' => 'Election Officer', 'order' => 5],
            ['name' => 'Asstt. Planning Officer', 'order' => 6],
            ['name' => 'Exicse Officer', 'order' => 7],
            ['name' => 'FAO', 'order' => 8],
            ['name' => 'District Manager', 'order' => 9],
            ['name' => 'District Project Officer', 'order' => 10],
            ['name' => 'Administrative Officer', 'order' => 11],
            ['name' => 'DDS', 'order' => 12],
            ['name' => 'Research Assistant', 'order' => 13],
            ['name' => 'Revenue sheristadar', 'order' => 14],
            ['name' => 'Head Assistant', 'order' => 15],
            ['name' => 'Senior District Administrative Assistant', 'order' => 16],
            ['name' => 'Stenographer Grade-III', 'order' => 17],
            ['name' => 'Stenographer Grade-I', 'order' => 18],
            ['name' => 'Junior District Administrative Assistant', 'order' => 19],
            ['name' => 'Superintendent of Accounts', 'order' => 20],
            ['name' => 'Computor', 'order' => 21],
            ['name' => 'Others', 'order' => 22],
            ['name' => 'Sub Divisional Officer (C)', 'order' => 23],
            ['name' => 'Circle Officer', 'order' => 24],
            ['name' => 'Consultant, ILRMS', 'order' => 25],
            ['name' => 'PFC Operator', 'order' => 26],
            ['name' => 'Computer Assistant', 'order' => 27],
            ['name' => 'DPM, edistrict', 'order' => 28],
            ['name' => 'Sub Divisional Officer (S)', 'order' => 29],
            ['name' => 'Superintendent of Exices', 'order' => 30],
            ['name' => 'Superintendent of F&CS', 'order' => 31],
            ['name' => 'Chief Accounts Officer', 'order' => 32],
        ];

        

        foreach ($designations as $desig) {
            Designation::firstOrCreate(
                ['slug' => Str::slug($desig['name'])],
                [
                    'name'                => $desig['name'],
                    'slug'                => Str::slug($desig['name']), 
                    'sort_order'          => $desig['order'],
                    'status'              => 'active',
                ]
            );
        }

        $this->command->info('✅ Designations seeded: ' . count($designations));
    }
}
