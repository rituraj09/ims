<?php
// app/Models/AssetMaintenance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'maintenance_type',
        'reference_no',
        'scheduled_date',
        'start_date',
        'completion_date',
        'vendor_id',
        'technician_name',
        'technician_contact',
        'issue_description',
        'work_done',
        'parts_replaced',
        'maintenance_cost',
        'invoice_no',
        'invoice_file',
        'status',
        'condition_after',
        'remarks',
        'document_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'scheduled_date'   => 'date',
        'start_date'       => 'date',
        'completion_date'  => 'date',
        'maintenance_cost' => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class, 'maintenance_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['scheduled', 'in_progress']);
    }

    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['scheduled', 'in_progress'])
                     ->where('scheduled_date', '<', now());
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    public function getDurationInDaysAttribute(): ?int
    {
        if (!$this->start_date) {
            return null;
        }

        $end = $this->completion_date ?? now();
        return $this->start_date->diffInDays($end);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'scheduled'   => 'info',
            'in_progress' => 'warning',
            'completed'   => 'success',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }
}
