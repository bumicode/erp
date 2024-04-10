<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemStockLevel extends Model
{
    use HasFactory;

    protected $table = 'item_stock_levels';

    protected $fillable = [
        'item_id',
        'stock',
        'uom_id',
        'warehouse_id',
    ];

    /*
     * Get the item that owns the stock level.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /*
     * Get the uom that owns the stock level.
     */
    public function uom(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    /*
     * Get the warehouse that owns the stock level.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
