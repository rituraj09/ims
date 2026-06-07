<?php
// database/seeders/SettingsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'app_name',       'value' => 'GovAsset Manager', 'type' => 'text',    'label' => 'Application Name',     'is_public' => true],
            ['group' => 'general', 'key' => 'app_timezone',   'value' => 'Asia/Kolkata',      'type' => 'text',    'label' => 'Timezone',             'is_public' => false],
            ['group' => 'general', 'key' => 'date_format',    'value' => 'd/m/Y',             'type' => 'text',    'label' => 'Date Format',          'is_public' => false],
            ['group' => 'general', 'key' => 'currency',       'value' => 'INR',               'type' => 'text',    'label' => 'Currency',             'is_public' => true],
            ['group' => 'general', 'key' => 'currency_symbol','value' => '₹',                 'type' => 'text',    'label' => 'Currency Symbol',      'is_public' => true],
            ['group' => 'general', 'key' => 'items_per_page', 'value' => '25',                'type' => 'integer', 'label' => 'Items Per Page',       'is_public' => false],

            // Organisation
            ['group' => 'organisation', 'key' => 'org_name',    'value' => '',  'type' => 'text',    'label' => 'Organisation Name',   'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_address',  'value' => '', 'type' => 'textarea', 'label' => 'Address',            'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_city',     'value' => '', 'type' => 'text',    'label' => 'City',                'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_state',    'value' => '', 'type' => 'text',    'label' => 'State',               'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_pincode',  'value' => '', 'type' => 'text',    'label' => 'Pincode',             'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_phone',    'value' => '', 'type' => 'text',    'label' => 'Phone',               'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_email',    'value' => '', 'type' => 'text',    'label' => 'Email',               'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_logo',     'value' => '', 'type' => 'file',    'label' => 'Logo',                'is_public' => true],
            ['group' => 'organisation', 'key' => 'org_website',  'value' => '', 'type' => 'text',    'label' => 'Website',             'is_public' => true],

            // Asset Tag Format
            ['group' => 'asset_tag', 'key' => 'format',      'value' => '{ORG_CODE}-{CAT_CODE}-{YEAR}-{SEQ}', 'type' => 'text',    'label' => 'Asset Tag Format',    'is_public' => false],
            ['group' => 'asset_tag', 'key' => 'org_code',    'value' => 'GOV',   'type' => 'text',    'label' => 'Organisation Code',   'is_public' => false],
            ['group' => 'asset_tag', 'key' => 'seq_digits',  'value' => '4',     'type' => 'integer', 'label' => 'Sequence Digits',     'is_public' => false],
            ['group' => 'asset_tag', 'key' => 'auto_generate','value' => '1',    'type' => 'boolean', 'label' => 'Auto Generate Tag',   'is_public' => false],

            // Notification Settings
            ['group' => 'notification', 'key' => 'warranty_alert_days',  'value' => '30',  'type' => 'integer', 'label' => 'Warranty Alert (days before expiry)', 'is_public' => false],
            ['group' => 'notification', 'key' => 'amc_alert_days',        'value' => '30', 'type' => 'integer', 'label' => 'AMC Alert (days before expiry)',      'is_public' => false],
            ['group' => 'notification', 'key' => 'email_notifications',   'value' => '1',  'type' => 'boolean', 'label' => 'Enable Email Notifications',          'is_public' => false],
            ['group' => 'notification', 'key' => 'admin_email',           'value' => '',   'type' => 'text',    'label' => 'Admin Notification Email',            'is_public' => false],

            // Backup
            ['group' => 'backup', 'key' => 'auto_backup',    'value' => '0',     'type' => 'boolean', 'label' => 'Enable Auto Backup',   'is_public' => false],
            ['group' => 'backup', 'key' => 'backup_frequency','value' => 'daily', 'type' => 'text',   'label' => 'Backup Frequency',     'is_public' => false],
            ['group' => 'backup', 'key' => 'backup_retention','value' => '30',   'type' => 'integer', 'label' => 'Backup Retention Days','is_public' => false],
            ['group' => 'backup', 'key' => 'backup_disk',    'value' => 'local', 'type' => 'text',    'label' => 'Backup Disk',          'is_public' => false],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded successfully.');
    }
}
