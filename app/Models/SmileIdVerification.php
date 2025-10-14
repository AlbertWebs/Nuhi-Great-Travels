<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmileIdVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'job_type',
        'result_code',
        'result_text',
        'partner_params',
        'actions',
        'images',
        'raw_response',
        'completed_at',
    ];

    protected $casts = [
        'partner_params' => 'array',
        'actions' => 'array',
        'images' => 'array',
        'raw_response' => 'array',
        'completed_at' => 'datetime',
    ];
}
