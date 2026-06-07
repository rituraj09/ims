<?php
// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_system_role',
    ];

    protected $casts = [
        'is_system_role' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        )->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    // ── Helpers ────────────────────────────────────────

    public function hasPermission(string $permissionName): bool
    {
        if (!$this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        return $this->permissions->contains('name', $permissionName);
    }

    public function givePermissionTo(string|array $permissions): void
    {
        $ids = Permission::whereIn('name', (array) $permissions)
                         ->pluck('id');
        $this->permissions()->syncWithoutDetaching($ids);
    }

    public function revokePermissionTo(string|array $permissions): void
    {
        $ids = Permission::whereIn('name', (array) $permissions)
                         ->pluck('id');
        $this->permissions()->detach($ids);
    }

    public function syncPermissions(array $permissions): void
    {
        $ids = Permission::whereIn('name', $permissions)->pluck('id');
        $this->permissions()->sync($ids);
    }
}
