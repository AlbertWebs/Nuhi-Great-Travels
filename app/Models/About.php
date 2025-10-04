<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = ['featured_image', 'description', 'mission', 'vision'];
}
