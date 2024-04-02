<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'city_code';

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code');
    }
}
