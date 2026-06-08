<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
         \App\Models\Asset::class => \App\Policies\AssetPolicy::class,
    ];

    public function boot(): void
    {
        // ── Super Admin bypasses ALL gates ────────────────
        Gate::before(function (User $user, string $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // ── Register all permissions dynamically ──────────
        $this->registerPermissions();
    }

    private function registerPermissions(): void
    {
        try {
            // Get all permissions from DB and register each as a Gate
            Permission::select('name')->get()->each(function ($permission) {
                Gate::define($permission->name, function (User $user) use ($permission) {
                    return $user->hasPermission($permission->name);
                });
            });
        } catch (\Exception $e) {
            // Fail silently if DB not ready (e.g., during migration)
        }
    }
}
