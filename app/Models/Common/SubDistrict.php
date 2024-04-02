<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubDistrict extends Model
{
    use HasFactory;

    protected $primaryKey = 'sub_district_code';

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_code');
    }
}
