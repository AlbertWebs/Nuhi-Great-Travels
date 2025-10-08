<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['make','model','year','slug','price','shape', 'description'];
    public function fleets()
    {
        return $this->hasMany(Fleet::class);
    }
}
