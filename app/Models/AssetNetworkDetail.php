<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetNetworkDetail extends Model
{
     protected $fillable = [
        'asset_id',
        'ethernet_mac',
        'wifi_mac',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
