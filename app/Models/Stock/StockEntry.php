<?php

namespace App\Models\Stock;

use App\Enums\Stock\StockEntryStatus;
use App\Traits\GeneratesUniqueNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockEntry extends Model
{
    use GeneratesUniqueNumber, HasFactory;

    public static $numberPrefix = 'STE'; // set the desired prefix
    public static $numberField = 'series'; // set the desired field name

    /*
     * The attributes that are mass assignable.
     */
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

    /*
     * The attributes that should be cast to native types.
     */
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

    /*
     * Get the stock entry type that owns the stock entry.
     */
    public function stockEntryType(): BelongsTo
    {
        return $this->belongsTo(StockEntryType::class);
    }

    /**
     * Get the items associated with the stock entry.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
}
