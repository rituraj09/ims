<?php
// app/Models/AssetCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AssetCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'depreciation_rate',
        'status',
        'sub_categories',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sub_categories'   => 'array',
        'depreciation_rate' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Sub-Category Helpers ──────────────────────────────────────────────

    /**
     * Add a new sub-category to JSON column
     */
    public function addSubCategory(array $subCategory): void
    {
        $subCategories   = $this->sub_categories ?? [];
        $subCategory['id']     = $subCategory['id'] ?? (string) Str::uuid();
        $subCategory['status'] = $subCategory['status'] ?? 'active';
        $subCategories[] = $subCategory;

        $this->update(['sub_categories' => $subCategories]);
    }

    /**
     * Update an existing sub-category by its UUID
     */
    public function updateSubCategory(string $uuid, array $data): bool
    {
        $subCategories = $this->sub_categories ?? [];

        $found = false;
        foreach ($subCategories as &$sub) {
            if ($sub['id'] === $uuid) {
                $sub   = array_merge($sub, $data);
                $found = true;
                break;
            }
        }
        unset($sub);

        if ($found) {
            $this->update(['sub_categories' => $subCategories]);
        }

        return $found;
    }

    /**
     * Remove a sub-category by UUID
     */
    public function removeSubCategory(string $uuid): bool
    {
        $subCategories = $this->sub_categories ?? [];
        $original      = count($subCategories);

        $subCategories = array_values(
            array_filter($subCategories, fn($s) => $s['id'] !== $uuid)
        );

        $this->update(['sub_categories' => $subCategories]);

        return count($subCategories) < $original;
    }

    /**
     * Find a sub-category by UUID
     */
    public function findSubCategory(string $uuid): ?array
    {
        return collect($this->sub_categories ?? [])
            ->firstWhere('id', $uuid);
    }

    /**
     * Get active sub-categories only
     */
    public function getActiveSubCategoriesAttribute(): array
    {
        return collect($this->sub_categories ?? [])
            ->where('status', 'active')
            ->values()
            ->toArray();
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function getSubCategoryIdAttribute()
    {
        return data_get($this->sub_category, 'id');
    }
}
