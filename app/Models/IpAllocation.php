<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpAllocation extends Model
{
    protected $fillable = [
        'ip_address_id',
        'user_id',
        'ethernet_mac',
        'wifi_mac',
        'dns_override',
        'device_name',
        'device_type',
        'date_allocated',
        'date_released',
        'status',
        'notes',
        'allocated_by',
    ];

    protected $casts = [
        'date_allocated' => 'date',
        'date_released'  => 'date',
    ];

    public function ipAddress(): BelongsTo
    {
        return $this->belongsTo(IpAddress::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function allocatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active'    => '<span class="badge bg-success">Active</span>',
            'released'  => '<span class="badge bg-secondary">Released</span>',
            'suspended' => '<span class="badge bg-warning text-dark">Suspended</span>',
            default     => '<span class="badge bg-light text-dark">' . $this->status . '</span>',
        };
    }
}
