<?php
// app/Models/AssetAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'transaction_type',
        'from_type',
        'from_department_id',
        'from_employee_id',
        'from_location_building',
        'from_location_floor',
        'from_location_room_no',
        'to_type',
        'to_department_id',
        'to_employee_id',
        'to_location_building',
        'to_location_floor',
        'to_location_room_no',
        'condition_at_handover',
        'condition_at_return',
        'transaction_date',
        'expected_return_date',
        'actual_return_date',
        'form_no',
        'handover_form_path',
        'handover_acknowledged',
        'handover_acknowledged_at',
        'takeover_acknowledged',
        'takeover_acknowledged_at',
        'authorized_by',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'transaction_date'          => 'date',
        'expected_return_date'      => 'date',
        'actual_return_date'        => 'date',
        'handover_acknowledged'     => 'boolean',
        'takeover_acknowledged'     => 'boolean',
        'handover_acknowledged_at'  => 'datetime',
        'takeover_acknowledged_at'  => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function fromDepartment()
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    public function fromEmployee()
    {
        return $this->belongsTo(User::class, 'from_employee_id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }

    public function toEmployee()
    {
        return $this->belongsTo(User::class, 'to_employee_id');
    }

    public function authorizedBy()
    {
        return $this->belongsTo(User::class, 'authorized_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class, 'assignment_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeHandovers($query)
    {
        return $query->where('transaction_type', 'handover');
    }

    public function scopeTakeovers($query)
    {
        return $query->where('transaction_type', 'takeover');
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('transaction_date', '>=', now()->subDays($days));
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Generate unique form number for handover/takeover
     */
    public static function generateFormNo(string $type): string
    {
        $prefix = match ($type) {
            'initial'    => 'IL',
            'handover'    => 'HO',
            'takeover'    => 'TO',
            'transfer'    => 'TR',
            'maintenance' => 'MR',
            default       => 'TX',
        };

        $year   = now()->format('Y');
        $month  = now()->format('m');
        $count  = self::whereYear('created_at', $year)
                      ->whereMonth('created_at', $month)
                      ->count() + 1;

        return "{$prefix}-{$year}{$month}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getFromHolderNameAttribute(): string
    {
        return match ($this->from_type) {
            'department' => $this->fromDepartment?->name ?? 'N/A',
            'employee'   => $this->fromEmployee?->name   ?? 'N/A',
            'store'      => 'Central Store',
            'vendor'     => 'Vendor',
            default      => 'N/A',
        };
    }

    public function getToHolderNameAttribute(): string
    {
        return match ($this->to_type) {
            'department' => $this->toDepartment?->name ?? 'N/A',
            'employee'   => $this->toEmployee?->name   ?? 'N/A',
            'store'      => 'Central Store',
            'vendor'     => 'Vendor',
            default      => 'N/A',
        };
    }
}
