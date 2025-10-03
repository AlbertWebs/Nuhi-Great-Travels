<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'subtitle_two',
        'button_text',
        'button_link',
        'video_link',
        'image',
    ];
}
