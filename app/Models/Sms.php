<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = ['message', 'recipients', 'status'];

    protected $casts = [
        'recipients' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users', 'id', 'id')
            ->whereIn('id', $this->recipients);
    }
}
