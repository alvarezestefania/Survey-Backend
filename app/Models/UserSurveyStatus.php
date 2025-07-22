<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSurveyStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
