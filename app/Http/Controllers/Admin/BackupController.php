<?php
// app/Http/Controllers/Admin/BackupController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BackupController extends Controller
{
    public function run(): RedirectResponse
    {
        try {
            Artisan::call('backup:run');
            return back()->with('success', 'Backup created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download(string $file): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = storage_path('app/backups/' . $file);
        abort_unless(file_exists($path), 404);
        return response()->download($path);
    }

    public function destroy(string $file): RedirectResponse
    {
        $path = storage_path('app/backups/' . $file);
        if (file_exists($path)) {
            unlink($path);
        }
        return back()->with('success', 'Backup deleted.');
    }
}
