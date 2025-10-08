<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fleet extends Model
{
    protected $fillable = [
    'car_id',
    'name',
    'slug',
    'type',
    'transmission',
    'fuel_type',
    'seats',
    'year',
    'price_per_day',
    'price',
    'image',
    'description',
    'content',
    'status',
];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
