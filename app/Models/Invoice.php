<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'fleet_id',
        'user_id',
        'full_name',
        'email',
        'mpesa_number',
        'pickup_date',
        'dropoff_date',
        'days',
        'price_per_day',
        'total_price',
        'is_sent',
        'status',
    ];

    // Relationships
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
