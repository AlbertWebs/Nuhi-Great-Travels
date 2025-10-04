<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fleet extends Model
{
    protected $fillable = ['name', 'type', 'image', 'description', 'price', 'car_id'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
