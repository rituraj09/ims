<?php
// app/Models/Asset.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    // ── Status & Condition Constants ──────────────────────────────────────

    const STATUS_AVAILABLE    = 'available';
    const STATUS_IN_USE       = 'in_use';
    const STATUS_MAINTENANCE  = 'under_maintenance';
    const STATUS_DISPOSED     = 'disposed';
    const STATUS_LOST         = 'lost';
    const STATUS_TRANSFERRED  = 'transferred';

    const CONDITION_NEW       = 'new';
    const CONDITION_GOOD      = 'good';
    const CONDITION_FAIR      = 'fair';
    const CONDITION_POOR      = 'poor';
    const CONDITION_CONDEMNED = 'condemned';

    protected $fillable = [
        'asset_tag',
        'name',
        'asset_type',
        'category_id',
        'sub_category_id',
        'sub_category_name',
        'make_brand',
        'model',
        'serial_no',
        'description',
        // Purchase & Financial
        'purchase_date',
        'purchase_price',
        'warranty_expiry_date',
        'under_amc',
        'amc_start_date',
        'amc_end_date',
        'amc_reference_no',
        'vendor_id',
        'invoice_no',
        'invoice_file',
        'depreciation_rate',
        'current_value',
        // Status
        'status',
        'condition',
        // Assignment
        'assigned_to_type',
        'assigned_department_id',
        'assigned_employee_id',
        'location_building',
        'location_block',
        'location_floor',
        'location_room_no',
        'assigned_on',
        'assignment_notes',
        // Disposal
        'disposed_on',
        'disposal_method',
        'disposal_value',
        'disposal_notes',
        // Other
        'qr_code_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'purchase_date'       => 'date',
        'warranty_expiry_date' => 'date',
        'amc_start_date'      => 'date',
        'amc_end_date'        => 'date',
        'assigned_on'         => 'date',
        'disposed_on'         => 'date',
        'under_amc'           => 'boolean',
        'purchase_price'      => 'decimal:2',
        'current_value'       => 'decimal:2',
        'depreciation_rate'   => 'decimal:2',
        'disposal_value'      => 'decimal:2',
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    // ── Relationships ─────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function assignedDepartment()
    {
        return $this->belongsTo(Department::class, 'assigned_department_id');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id')
                    ->orderByDesc('transaction_date');
    }

    public function latestAssignment()
    {
        return $this->hasOne(AssetAssignment::class, 'asset_id')
                    ->latestOfMany('transaction_date');
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class, 'asset_id')
                    ->orderByDesc('start_date');
    }

    public function activeMaintenances()
    {
        return $this->hasMany(AssetMaintenance::class, 'asset_id')
                    ->whereIn('status', ['scheduled', 'in_progress']);
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class, 'asset_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeInUse($query)
    {
        return $query->where('status', self::STATUS_IN_USE);
    }

    public function scopeUnderMaintenance($query)
    {
        return $query->where('status', self::STATUS_MAINTENANCE);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('assigned_department_id', $departmentId);
    }

    public function scopeByEmployee($query, int $userId)
    {
        return $query->where('assigned_employee_id', $userId);
    }

    public function scopeWarrantyExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('warranty_expiry_date')
                     ->whereBetween('warranty_expiry_date', [
                         now(),
                         now()->addDays($days),
                     ]);
    }

    public function scopeAmcExpiringSoon($query, int $days = 30)
    {
        return $query->where('under_amc', true)
                     ->whereNotNull('amc_end_date')
                     ->whereBetween('amc_end_date', [
                         now(),
                         now()->addDays($days),
                     ]);
    }

    // ── Business Logic Helpers ────────────────────────────────────────────

    /**
     * Calculate current value based on WDV (Written Down Value) method
     */
    public function calculateCurrentValue(): float
    {
        if (!$this->purchase_price || !$this->purchase_date) {
            return (float) ($this->purchase_price ?? 0);
        }

        $rate  = ($this->depreciation_rate ?? 0) / 100;
        $years = $this->purchase_date->diffInDays(now()) / 365;

        // WDV method: Current Value = Purchase Price × (1 - rate)^years
        $value = $this->purchase_price * pow(1 - $rate, $years);

        return max(round($value, 2), 0);
    }

    /**
     * Check if warranty is still valid
     */
    public function isUnderWarranty(): bool
    {
        return $this->warranty_expiry_date
            && $this->warranty_expiry_date->isFuture();
    }

    /**
     * Check if AMC is currently active
     */
    public function isAmcActive(): bool
    {
        return $this->under_amc
            && $this->amc_end_date
            && $this->amc_end_date->isFuture();
    }

    /**
     * Get the current holder (department or employee)
     */
    public function getCurrentHolder(): ?Model
    {
        return match ($this->assigned_to_type) {
            'department' => $this->assignedDepartment,
            'employee'   => $this->assignedEmployee,
            default      => null,
        };
    }

    /**
     * Get human readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available'         => 'Available',
            'in_use'            => 'In Use',
            'under_maintenance' => 'Under Maintenance',
            'disposed'          => 'Disposed',
            'lost'              => 'Lost',
            'transferred'       => 'Transferred',
            default             => ucfirst($this->status),
        };
    }

    /**
     * Get status badge color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'available'         => 'success',
            'in_use'            => 'primary',
            'under_maintenance' => 'warning',
            'disposed'          => 'danger',
            'lost'              => 'dark',
            'transferred'       => 'info',
            default             => 'secondary',
        };
    }

    /**
     * Get condition badge color for UI
     */
    public function getConditionColorAttribute(): string
    {
        return match ($this->condition) {
            'new'       => 'success',
            'good'      => 'info',
            'fair'      => 'warning',
            'poor'      => 'danger',
            'condemned' => 'dark',
            default     => 'secondary',
        };
    }
}
