<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farm extends Model
{
    //use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location_address',
        'longitude',
        'latitude',
        'size',
        'farm_size_unit_id',
        'status',
    ];

    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class);
    }
}
