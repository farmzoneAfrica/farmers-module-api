<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceBiometric extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio_data',
        'is_flagged'
    ];
}