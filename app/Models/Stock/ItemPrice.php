<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ItemPrice extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'item_id',
        'uom_id',
        'packing_unit',
        'price_list_id',
        'is_buying',
        'is_selling',
        'batch_id',
        'currency_id',
        'rate',
        'valid_from',
        'valid_upto',
        'lead_time_in_days',
        'note',
    ];

    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function uom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    public function priceList(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }

    public function batch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}
