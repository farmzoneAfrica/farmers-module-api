<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmCrop extends Model
{
    //use HasFactory;

    protected $fillable = [
        'user_id',
        'farm_id',
        'crop_id',
        'crop_status_id',
        'last_changed',
    ];
}
