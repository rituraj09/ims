<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IpAddress extends Model
{
    protected $fillable = [
        'ip_address',
        'subnet_mask',
        'gateway',
        'dns_primary',
        'dns_secondary',
        'network_type',
        'vlan',
        'description',
        'status',
    ];

    public function allocations(): HasMany
    {
        return $this->hasMany(IpAllocation::class);
    }

    public function activeAllocation(): HasOne
    {
        return $this->hasOne(IpAllocation::class)->where('status', 'active')->latestOfMany();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'available'      => '<span class="badge bg-success">Available</span>',
            'allocated'      => '<span class="badge bg-primary">Allocated</span>',
            'reserved'       => '<span class="badge bg-warning text-dark">Reserved</span>',
            'decommissioned' => '<span class="badge bg-secondary">Decommissioned</span>',
            default          => '<span class="badge bg-light text-dark">' . $this->status . '</span>',
        };
    }
}
