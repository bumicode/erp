<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;

class ItemInventory extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'item_inventories';

    protected $fillable = [
        'item_id',
        'shelf_life',
        'warranty_period',
        'end_of_life',
        'weight_per_unit',
        'default_material_request_type',
        'allow_negative_stock',
        'valuation_method',
        'weight_uom_id',
        'created_by',
        'updated_by',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function weightUom(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'weight_uom_id');
    }
}
