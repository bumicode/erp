<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'province_code';

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
