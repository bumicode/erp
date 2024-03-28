<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'code',
        'name',
        'symbol',
        'status',
        'fraction',
        'fraction_units',
        'smallest_currency_fraction_value',
        'show_currency_symbol_on_right_side',
        'number_format',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
