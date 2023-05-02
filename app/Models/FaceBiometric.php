<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceBiometric extends Model
{
    protected $fillable = [
        "user_id",
        "user_code",
        "facial_id",
        "date_enrolled",
        "age",
        "gender",
        "bio_data",
        "provider"
    ];
}
