<?php
// database/seeders/AssetCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetCategory;
use Illuminate\Support\Str;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'              => 'IT Equipment',
                'code'              => 'IT',
                'description'       => 'Computers, laptops, servers and other IT devices',
                'icon'              => 'fas fa-laptop',
                'depreciation_rate' => 33.33,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Desktop Computer', 'code' => 'DKT', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Laptop',           'code' => 'LAP', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Server',           'code' => 'SRV', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Printer',          'code' => 'PRN', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Scanner',          'code' => 'SCN', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'UPS',              'code' => 'UPS', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Projector',        'code' => 'PRJ', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Network Switch',   'code' => 'NSW', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Wi-Fi Router',     'code' => 'WFR', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'CCTV Camera',      'code' => 'CTV', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Furniture',
                'code'              => 'FRN',
                'description'       => 'Office furniture and fixtures',
                'icon'              => 'fas fa-chair',
                'depreciation_rate' => 10.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Chair',           'code' => 'CHR', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Table / Desk',    'code' => 'TBL', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Almirah',         'code' => 'ALM', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Sofa',            'code' => 'SFA', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Filing Cabinet',  'code' => 'FCB', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Bookshelf',       'code' => 'BSF', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Partition',       'code' => 'PRT', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Electrical Equipment',
                'code'              => 'ELE',
                'description'       => 'Air conditioners, fans and electrical appliances',
                'icon'              => 'fas fa-plug',
                'depreciation_rate' => 15.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Air Conditioner', 'code' => 'ACU', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Ceiling Fan',     'code' => 'CFN', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Refrigerator',    'code' => 'RFG', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Water Purifier',  'code' => 'WPR', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Microwave Oven',  'code' => 'MWV', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Vehicle',
                'code'              => 'VHL',
                'description'       => 'Official vehicles',
                'icon'              => 'fas fa-car',
                'depreciation_rate' => 20.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Car',      'code' => 'CAR', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Jeep',     'code' => 'JEP', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Bus',      'code' => 'BUS', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Truck',    'code' => 'TRK', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Motorcycle','code' => 'MCY', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Communication Equipment',
                'code'              => 'COM',
                'description'       => 'Phones, intercom and communication devices',
                'icon'              => 'fas fa-phone',
                'depreciation_rate' => 20.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Landline Phone', 'code' => 'LPN', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Mobile Phone',   'code' => 'MBL', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Intercom',       'code' => 'ICM', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Walkie-Talkie',  'code' => 'WTK', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Fax Machine',    'code' => 'FAX', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Medical Equipment',
                'code'              => 'MED',
                'description'       => 'Medical and health-related equipment',
                'icon'              => 'fas fa-stethoscope',
                'depreciation_rate' => 15.00,
                'status'            => 'active',
                'sub_categories'    => [],
            ],
            [
                'name'              => 'Safety Equipment',
                'code'              => 'SAF',
                'description'       => 'Fire safety and security equipment',
                'icon'              => 'fas fa-fire-extinguisher',
                'depreciation_rate' => 15.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Fire Extinguisher', 'code' => 'FEX', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Smoke Detector',    'code' => 'SMK', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Security Camera',   'code' => 'SCA', 'status' => 'active'],
                ],
            ],
            [
                'name'              => 'Office Equipment',
                'code'              => 'OFF',
                'description'       => 'General office equipment',
                'icon'              => 'fas fa-briefcase',
                'depreciation_rate' => 15.00,
                'status'            => 'active',
                'sub_categories'    => [
                    ['id' => Str::uuid(), 'name' => 'Photocopier',       'code' => 'PHC', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Shredder',          'code' => 'SHR', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Laminator',         'code' => 'LAM', 'status' => 'active'],
                    ['id' => Str::uuid(), 'name' => 'Paper Weight Scale','code' => 'PWS', 'status' => 'active'],
                ],
            ],
        ];

        foreach ($categories as $cat) {
            AssetCategory::firstOrCreate(
                ['code' => $cat['code']],
                $cat
            );
        }

        $this->command->info('✅ Asset categories seeded: ' . count($categories) . ' categories');
    }
}
