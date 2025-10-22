<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title','notes','planned_date','planned_time','is_completed','completed_at'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'planned_date' => 'date',
        'planned_time' => 'string',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }


}
