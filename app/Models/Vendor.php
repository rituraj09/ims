<?php
// app/Models/Vendor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'contact_person',
        'mobile',
        'phone',
        'email',
        'website',
        'address',
        'city',
        'state',
        'pincode',
        'country',
        'gstin',
        'pan',
        'bank_name',
        'bank_account_no',
        'bank_ifsc',
        'provides_amc',
        'amc_terms',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'provides_amc' => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function assets()
    {
        return $this->hasMany(Asset::class, 'vendor_id');
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class, 'vendor_id');
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAmcProviders($query)
    {
        return $query->where('provides_amc', true);
    }

    // ── Accessors ─────────────────────────────────────────────────────────

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->pincode,
        ]);
        return implode(', ', $parts) ?: 'N/A';
    }
}
