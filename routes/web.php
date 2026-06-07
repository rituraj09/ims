<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetCategoryController;
use App\Http\Controllers\Admin\AssetAssignmentController;
use App\Http\Controllers\Admin\AssetMaintenanceController;
use App\Http\Controllers\Admin\AssetDocumentController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\NotificationController;

/* ═══════════════════════════════════════════════════════
   PUBLIC ROUTES - No Auth Required
═══════════════════════════════════════════════════════ */

// ── Auth Routes (Guest Only) ──────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])
         ->name('login');
    Route::post('/login', [LoginController::class, 'login'])
         ->name('login.submit');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');

/* ═══════════════════════════════════════════════════════
   AUTHENTICATED ROUTES
═══════════════════════════════════════════════════════ */
Route::middleware(['auth', 'user.status'])->group(function () {

    // Dashboard (Root)
    Route::get('/', [DashboardController::class, 'index'])
         ->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard.home');

    // ── Profile ──────────────────────────────────────
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',         [ProfileController::class, 'show'])
             ->name('show');
        Route::put('/',         [ProfileController::class, 'update'])
             ->name('update');
        Route::get('/password', [ProfileController::class, 'password'])
             ->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])
             ->name('password.update');
        Route::post('/photo',   [ProfileController::class, 'updatePhoto'])
             ->name('photo.update');
    });

    /* ═══════════════════════════════════════════════
       ADMIN ROUTES
    ═══════════════════════════════════════════════ */
    Route::prefix('admin')->name('admin.')->group(function () {

        // ── Designations ─────────────────────────
        Route::middleware('permission:users.view')
            ->resource('designations', \App\Http\Controllers\Admin\DesignationController::class);
        // ── Assets ───────────────────────────────
        Route::prefix('assets')->name('assets.')
             ->middleware('permission:assets.view')
             ->group(function () {

            Route::get('/',              [AssetController::class, 'index'])
                 ->name('index');
            Route::get('/{asset}',       [AssetController::class, 'show'])
                 ->name('show');

            Route::middleware('permission:assets.create')->group(function () {
                Route::get('/create',    [AssetController::class, 'create'])
                     ->name('create');
                Route::post('/',         [AssetController::class, 'store'])
                     ->name('store');
            });

            Route::middleware('permission:assets.edit')->group(function () {
                Route::get('/{asset}/edit',  [AssetController::class, 'edit'])
                     ->name('edit');
                Route::put('/{asset}',       [AssetController::class, 'update'])
                     ->name('update');
            });

            Route::delete('/{asset}', [AssetController::class, 'destroy'])
                 ->name('destroy')
                 ->middleware('permission:assets.delete');

            // Assignment Actions
            Route::middleware('permission:assets.assign')->group(function () {
                Route::get('/{asset}/assign',
                    [AssetAssignmentController::class, 'create'])
                     ->name('assign');
                Route::post('/{asset}/assign',
                    [AssetAssignmentController::class, 'store'])
                     ->name('assign.store');
                Route::post('/{asset}/takeover',
                    [AssetAssignmentController::class, 'takeover'])
                     ->name('takeover');
                Route::post('/{asset}/transfer',
                    [AssetAssignmentController::class, 'transfer'])
                     ->name('transfer');
            });

            // Utilities
            Route::get('/generate-tag',      [AssetController::class, 'generateTag'])
                 ->name('generate-tag');
            Route::get('/{asset}/qr',        [AssetController::class, 'generateQr'])
                 ->name('qr');
            Route::get('/{asset}/print',     [AssetController::class, 'printLabel'])
                 ->name('print');
        });

        // ── Asset Assignments ──────────────────────
        Route::prefix('assignments')->name('assignments.')->group(function () {
            Route::get('/',
                [AssetAssignmentController::class, 'index'])
                 ->name('index');
            Route::get('/{id}',
                [AssetAssignmentController::class, 'show'])
                 ->name('show');
            Route::get('/{id}/print',
                [AssetAssignmentController::class, 'printForm'])
                 ->name('print');
            Route::post('/{id}/upload-form',
                [AssetAssignmentController::class, 'uploadForm'])
                 ->name('upload-form');
        });

        // ── Categories ─────────────────────────────
        Route::middleware('permission:categories.view')
             ->resource('categories', AssetCategoryController::class);

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::post('/{category}/sub-categories',
                [AssetCategoryController::class, 'addSubCategory'])
                 ->name('sub.add');
            Route::put('/{category}/sub-categories/{uuid}',
                [AssetCategoryController::class, 'updateSubCategory'])
                 ->name('sub.update');
            Route::delete('/{category}/sub-categories/{uuid}',
                [AssetCategoryController::class, 'deleteSubCategory'])
                 ->name('sub.delete');
        });

        // ── Maintenance ────────────────────────────
        Route::middleware('permission:maintenance.view')
             ->resource('maintenances', AssetMaintenanceController::class);

        // ── Documents ──────────────────────────────
        Route::prefix('documents')->name('documents.')->group(function () {
            Route::post('/upload',
                [AssetDocumentController::class, 'upload'])
                 ->name('upload');
            Route::delete('/{doc}',
                [AssetDocumentController::class, 'destroy'])
                 ->name('destroy');
            Route::get('/{doc}/download',
                [AssetDocumentController::class, 'download'])
                 ->name('download');
        });

        // ── Departments ────────────────────────────
        Route::middleware('permission:departments.view')
             ->resource('departments', DepartmentController::class);

        // ── Employees ──────────────────────────────
        Route::middleware('permission:employees.view')
             ->resource('employees', EmployeeController::class);
        Route::get('/employees/{employee}/assets',
            [EmployeeController::class, 'assets'])
             ->name('employees.assets');

        // ── Vendors ────────────────────────────────
        Route::middleware('permission:vendors.view')
             ->resource('vendors', VendorController::class);

        // ── Reports ────────────────────────────────
        Route::prefix('reports')->name('reports.')
             ->middleware('permission:reports.view')
             ->group(function () {
            Route::get('/assets',        [ReportController::class, 'assets'])
                 ->name('assets');
            Route::get('/department',    [ReportController::class, 'department'])
                 ->name('department');
            Route::get('/depreciation',  [ReportController::class, 'depreciation'])
                 ->name('depreciation');
            Route::get('/warranty',      [ReportController::class, 'warranty'])
                 ->name('warranty');
            Route::get('/amc',           [ReportController::class, 'amc'])
                 ->name('amc');
            Route::get('/export/{type}', [ReportController::class, 'export'])
                 ->name('export');
        });

        // ── Users ──────────────────────────────────
        Route::middleware('permission:users.view')
             ->resource('users', UserController::class);
        Route::post('/users/{user}/toggle-status',
            [UserController::class, 'toggleStatus'])
             ->name('users.toggle-status');
        Route::post('/users/{user}/reset-password',
            [UserController::class, 'resetPassword'])
             ->name('users.reset-password');

        // ── Roles & Permissions ────────────────────
        Route::prefix('roles')->name('roles.')
             ->middleware('permission:roles.manage')
             ->group(function () {
            Route::get('/',
                [RoleController::class, 'index'])
                 ->name('index');
            Route::get('/{role}/permissions',
                [RoleController::class, 'permissions'])
                 ->name('permissions');
            Route::post('/{role}/permissions',
                [RoleController::class, 'updatePermissions'])
                 ->name('permissions.update');
        });

        // ── Settings ───────────────────────────────
        Route::prefix('settings')->name('settings.')
             ->middleware('permission:settings.view')
             ->group(function () {
            Route::get('/general',
                [SettingController::class, 'general'])
                 ->name('general');
            Route::post('/general',
                [SettingController::class, 'updateGeneral'])
                 ->name('general.update');
            Route::get('/organisation',
                [SettingController::class, 'organisation'])
                 ->name('organisation');
            Route::post('/organisation',
                [SettingController::class, 'updateOrganisation'])
                 ->name('organisation.update');
            Route::get('/notification',
                [SettingController::class, 'notification'])
                 ->name('notification');
            Route::post('/notification',
                [SettingController::class, 'updateNotification'])
                 ->name('notification.update');
            Route::get('/backup',
                [SettingController::class, 'backup'])
                 ->name('backup');
            Route::post('/backup/run',
                [BackupController::class, 'run'])
                 ->name('backup.run');
            Route::get('/backup/download/{file}',
                [BackupController::class, 'download'])
                 ->name('backup.download');
            Route::delete('/backup/{file}',
                [BackupController::class, 'destroy'])
                 ->name('backup.destroy');
        });

        // ── Activity Logs ──────────────────────────
        Route::get('/activity-logs',
            [ActivityLogController::class, 'index'])
             ->name('activity-logs.index');

        // ── Notifications ──────────────────────────
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/',
                [NotificationController::class, 'index'])
                 ->name('index');
            Route::post('/{id}/read',
                [NotificationController::class, 'markRead'])
                 ->name('markRead');
            Route::post('/mark-all-read',
                [NotificationController::class, 'markAllRead'])
                 ->name('markAllRead');
        });

        // ── AJAX Helpers ───────────────────────────
        Route::prefix('ajax')->name('ajax.')->group(function () {
            Route::get('/departments',
                [DepartmentController::class, 'ajaxList'])
                 ->name('departments');
            Route::get('/employees',
                [EmployeeController::class, 'ajaxList'])
                 ->name('employees');
            Route::get('/vendors',
                [VendorController::class, 'ajaxList'])
                 ->name('vendors');
            Route::get('/categories',
                [AssetCategoryController::class, 'ajaxList'])
                 ->name('categories');
            Route::get('/sub-categories/{category}',
                [AssetCategoryController::class, 'ajaxSubCategories'])
                 ->name('sub-categories');
            Route::get('/assets',
                [AssetController::class, 'ajaxList'])
                 ->name('assets');
        });

    }); // End Admin Routes

}); // End Auth Routes
