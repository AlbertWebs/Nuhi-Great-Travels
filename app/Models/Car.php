<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['make','model','year','price','shape', 'description'];
    public function fleets()
    {
        return $this->hasMany(Fleet::class);
    }
}
