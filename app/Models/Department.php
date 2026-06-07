<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'parent_id',
        'head_user_id',
        'building',
        'block',
        'floor',
        'room_no',
        'address',
        'city',
        'state',
        'pincode',
        'phone',
        'email',
        'status',
        'notes',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    /**
     * Recursively get all nested children
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'assigned_department_id');
    }

    public function assetAssignments()
    {
        return $this->hasMany(AssetAssignment::class, 'to_department_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRootDepartments($query)
    {
        return $query->whereNull('parent_id');
    }

    // ── Accessors ─────────────────────────────────────────────────────────

    public function getFullLocationAttribute(): string
    {
        $parts = array_filter([
            $this->room_no  ? "Room: {$this->room_no}"  : null,
            $this->floor    ? "Floor: {$this->floor}"   : null,
            $this->building ? "Bldg: {$this->building}" : null,
        ]);
        return implode(', ', $parts) ?: 'N/A';
    }

    public function getAssetCountAttribute(): int
    {
        return $this->assets()->count();
    }
}
