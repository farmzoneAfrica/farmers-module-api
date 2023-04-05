<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp',
        'phone',
        'status',
        'gateway',
        'callback_response',
        'reference',
        'time_completed',
        'created_at',
        'updated_at'
    ];
}
