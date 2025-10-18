<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesapalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'merchant_reference',
        'payment_method',
        'payment_status',
        'payment_status_description',
        'amount',
        'currency',
        'sender_phone',
        'sender_name',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'amount' => 'decimal:2',
    ];
}
