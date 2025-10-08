<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycSubmission extends Model
{
    protected $fillable = [
        'name',
        'document_type',
        'document_image',
        'selfie_image',
        'liveliness_data',
        'status',
    ];
}
