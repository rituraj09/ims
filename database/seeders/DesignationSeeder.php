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
            ['name' => 'District Commissioner',              'category' => 'Gazetted',     'order' => 1],
            ['name' => 'Additional District Commissioner',   'category' => 'Gazetted',     'order' => 2],
            ['name' => 'Assistant Commissioner',        'category' => 'Gazetted',     'order' => 3],
            ['name' => 'DIO',       'category' => 'Gazetted',     'order' => 4],
            ['name' => 'FAO',        'category' => 'Gazetted',     'order' => 5],
            ['name' => 'Dist. Manager',        'category' => 'Non-Gazetted',     'order' => 6],
            ['name' => 'DPO','category'=> 'Non-Gazetted', 'order' => 7],
            ['name' => 'Administrative Officer','category'=> 'Non-Gazetted', 'order' => 8],
            ['name' => 'Revenue Shrestadar','category'=> 'Non-Gazetted', 'order' => 9],
            ['name' => 'ILRMS Consultant','category'=> 'Non-Gazetted', 'order' => 10],
            ['name' => 'ADPO','category'=> 'Non-Gazetted', 'order' => 11],
            ['name' => 'JDO','category'=> 'Non-Gazetted', 'order' => 12],
            ['name' => 'SDAA',       'category' => 'Non-Gazetted', 'order' => 13],
            ['name' => 'JDAA',              'category' => 'Non-Gazetted', 'order' => 14],
            ['name' => 'Driver',                 'category' => 'Group D',      'order' => 15],
        ];

        foreach ($designations as $desig) {
            Designation::firstOrCreate(
                ['slug' => Str::slug($desig['name'])],
                [
                    'name'                => $desig['name'],
                    'slug'                => Str::slug($desig['name']),
                    'department_category' => $desig['category'],
                    'sort_order'          => $desig['order'],
                    'status'              => 'active',
                ]
            );
        }

        $this->command->info('✅ Designations seeded: ' . count($designations));
    }
}
