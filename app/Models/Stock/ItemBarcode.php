<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemBarcode extends Model
{
    use HasFactory;

    protected $table = 'item_has_barcodes';

    protected $fillable = [
        'item_id',
        'barcode',
        'barcode_type',
        'uom_id',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function uom(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }
}
