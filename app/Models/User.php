<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'mobile',
        'gender',
        'profile_photo',
        'designation_id',
        'department_id',
        'password',
        'role_id',
        'is_system_user',
        'email_verified_at',
        'status',
        'joining_date',
        'leaving_date',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'joining_date'      => 'date',
        'leaving_date'      => 'date',
        'is_system_user'    => 'boolean',
        'password'          => 'hashed',
    ];

    // ── Relationships ──────────────────────────────────

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function userPermissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'user_permissions',
            'user_id',
            'permission_id'
        )->withPivot('type')->withTimestamps();
    }

    public function assignedAssets()
    {
        return $this->hasMany(Asset::class, 'assigned_employee_id');
    }
    public function assignedAssetsIT()
    {
        return $this->hasMany(Asset::class, 'assigned_employee_id')
            ->where('asset_type', 'IT');
    }
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    // ── Role Helpers ───────────────────────────────────

    /**
     * Check if Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'super_admin';
    }

    /**
     * Check if Admin or Super Admin
     */
    public function isAdmin(): bool
    {
        return in_array($this->role?->name, ['super_admin', 'admin']);
    }

    /**
     * Check specific role
     */
    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;
        return in_array($this->role?->name, $roles);
    }

    // ── Permission Helpers ─────────────────────────────

    /**
     * Check if user has a specific permission
     * Super Admin = always true
     * Priority: User deny > User grant > Role permission
     */
    public function hasPermission(string $permissionName): bool
    {
        // Super Admin has everything
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check user-level permission overrides
        // Load only if not already loaded
        if ($this->relationLoaded('userPermissions')) {
            $userPerm = $this->userPermissions
                ->firstWhere('name', $permissionName);
        } else {
            $userPerm = $this->userPermissions()
                ->where('name', $permissionName)
                ->first();
        }

        if ($userPerm) {
            return $userPerm->pivot->type === 'grant';
        }

        // Fall back to role permissions
        if (!$this->relationLoaded('role')) {
            $this->load('role.permissions');
        }

        return $this->role?->hasPermission($permissionName) ?? false;
    }

    /**
     * Check if user has ANY of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        // Super Admin has everything
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has ALL of the given permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    // ── Accessors ──────────────────────────────────────

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        return 'https://ui-avatars.com/api/?name=' .
               urlencode($this->name) .
               '&background=3b82f6&color=fff&size=80&bold=true';
    }

    // ── Scopes ─────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSystemUsers($query)
    {
        return $query->where('is_system_user', true);
    }
}
