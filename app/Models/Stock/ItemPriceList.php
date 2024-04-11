<?php

namespace App\Models\Stock;

use App\Models\Common\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPriceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'name',
        'currency_id',
        'is_buying',
        'is_selling',
        'is_price_not_uom_dependent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_buying' => 'boolean',
        'is_selling' => 'boolean',
    ];

    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
