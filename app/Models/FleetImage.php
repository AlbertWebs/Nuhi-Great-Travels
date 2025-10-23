<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetImage extends Model
{
    protected $fillable = [
        'fleet_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }
}
