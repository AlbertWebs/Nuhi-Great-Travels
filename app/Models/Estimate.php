<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_number',
        'user_id',
        'full_name',
        'email',
        'mpesa_number',
        'pickup_date',
        'dropoff_date',
        'days',
        'price_per_day',
        'total_price',
        'status',
        'converted_at',
        'converted_invoice_id',
        'is_sent',
        'notes',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'dropoff_date' => 'date',
        'converted_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function convertedInvoice()
    {
        return $this->belongsTo(Invoice::class, 'converted_invoice_id');
    }

    public function fleets()
    {
        return $this->belongsToMany(Fleet::class, 'estimate_fleet')
            ->withPivot(['price_per_day', 'quantity'])
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Estimate $estimate) {
            if (empty($estimate->estimate_number)) {
                $estimate->estimate_number = 'EST-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }
}

