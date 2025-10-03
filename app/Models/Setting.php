<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'email',
        'mobile',
        'location',
        'facebook',
        'instagram',
        'tiktok',
        'twitter',
        'youtube',
        'map_iframe',
        'logo',
        'favicon',
        'linkedin',
        'tawkto',
        'whatsapp',
    ];
}
