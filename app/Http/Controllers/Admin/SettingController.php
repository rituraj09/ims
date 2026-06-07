<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function general(): View
    {
        $settings = Setting::getGroup('general');
        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $request->validate([
            'app_name'      => ['required', 'string', 'max:100'],
            'date_format'   => ['required', 'string'],
            'currency'      => ['required', 'string', 'max:10'],
            'items_per_page'=> ['required', 'integer', 'min:10', 'max:200'],
        ]);

        foreach ($request->except('_token', '_method') as $key => $value) {
            Setting::set("general.{$key}", $value);
        }

        Setting::clearCache();

        return back()->with('success', 'General settings updated successfully.');
    }

    public function organisation(): View
    {
        $settings = Setting::getGroup('organisation');
        return view('admin.settings.organisation', compact('settings'));
    }

    public function updateOrganisation(Request $request): RedirectResponse
    {
        $data = $request->except('_token', '_method', 'org_logo');

        // Handle logo upload
        if ($request->hasFile('org_logo')) {
            $path = $request->file('org_logo')->store('organisation', 'public');
            Setting::set('organisation.org_logo', $path);
        }

        foreach ($data as $key => $value) {
            Setting::set("organisation.{$key}", $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Organisation settings updated successfully.');
    }

    public function notification(): View
    {
        $settings = Setting::getGroup('notification');
        return view('admin.settings.notification', compact('settings'));
    }

    public function updateNotification(Request $request): RedirectResponse
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            Setting::set("notification.{$key}", $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Notification settings updated successfully.');
    }

    public function backup(): View
    {
        $backups = BackupLog::latest()->paginate(20);
        $backupPath = storage_path('app/backups');
        $files = [];

        if (is_dir($backupPath)) {
            $files = array_diff(scandir($backupPath), ['.', '..']);
        }

        $settings = Setting::getGroup('backup');

        return view('admin.settings.backup', compact('backups', 'files', 'settings'));
    }
}
