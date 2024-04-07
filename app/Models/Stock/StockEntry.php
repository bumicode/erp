<?php

namespace App\Models\Stock;

use App\Enums\Stock\StockEntryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'series',
        'stock_entry_type_id',
        'is_inspection_required',
        'posting_at',
        'items',
        'total_outgoing',
        'total_incoming',
        'total_value',
        'additional_costs',
        'total_additional_cost',
    ];

    protected $casts = [
        'items' => 'json',
        'total_outgoing' => 'float',
        'total_incoming' => 'float',
        'total_value' => 'float',
        'additional_costs' => 'json',
        'total_additional_cost' => 'float',
        'posting_at' => 'datetime',
        'status' => StockEntryStatus::class,
    ];

    public function stockEntryType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StockEntryType::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Item::class);
    }
}
