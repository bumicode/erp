<?php

namespace App\Models\Stock;

use App\Enums\Stock\ItemStatus;
use App\Traits\GeneratesUniqueNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Item extends Model
{
    use GeneratesUniqueNumber, HasFactory, SoftDeletes, Userstamps;

    public static $numberPrefix = 'ITM'; // set the desired prefix
    public static $numberField = 'code'; // set the desired field name
    public static $withYear = false; // set true to include the year in the generated number


    /**
     * Indicates the fields that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'status',
        'allow_alternative_item',
        'maintain_stock',
        'is_fixed_asset',
        'has_variant',
        'code',
        'name',
        'description',
        'variant_base_on',
        'allow_purchase',
        'over_delivery_allowance',
        'over_billing_allowance',
        'created_by',
        'updated_by',
        'parent_id',
        'item_group_id',
        'default_uom_id',
        'brand_id',
        'shelf_life',
        'warranty_period',
        'end_of_life',
        'weight_per_unit',
        'default_material_request_type',
        'allow_negative_stock',
        'valuation_method',
        'weight_uom_id',
        'standard_selling_rate',
        'standard_buying_rate',
        'opening_stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => ItemStatus::class,
        'active' => 'boolean',
        'allow_alternative_item' => 'boolean',
        'maintain_stock' => 'boolean',
        'is_fixed_asset' => 'boolean',
        'has_variant' => 'boolean',
        'allow_purchase' => 'boolean',
        'allow_negative_stock' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'end_of_life',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the parent item of the item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    /**
     * Get the children items of the item.
     */
    public function childrens(): HasMany
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    /**
     * Get the item group that owns the item.
     */
    public function itemGroup(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class);
    }

    /**
     * Get the brand associated with the item.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the default unit of measure for the item.
     */
    public function defaultUom(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    /**
     * Get the inventory record associated with the item.
     */
    public function itemInventory(): HasOne
    {
        return $this->hasOne(ItemInventory::class);
    }

    /**
     * Get all the conversions for the item.
     */
    public function conversions(): MorphMany
    {
        return $this->morphMany(Conversion::class, 'convertible');
    }

    /**
     * Get all the prices for the item.
     */
    public function itemPrices(): HasMany
    {
        return $this->hasMany(ItemPrice::class);
    }

    /**
     * Get the selling prices for the item.
     */
    public function sellingPrice(): HasMany
    {
        return $this->hasMany(ItemPrice::class)->where('is_selling', true);
    }

    /**
     * Get the buying prices for the item.
     */
    public function buyingPrice(): HasMany
    {
        return $this->hasMany(ItemPrice::class)->where('is_buying', true);
    }

    /**
     * Get the item barcodes
     */
    public function itemBarcodes(): HasMany
    {
        return $this->hasMany(ItemBarcode::class);
    }

    /**
     * Get the item uom conversion
     */
    public function itemUomConversion(): HasMany
    {
        return $this->hasMany(ItemUom::class);
    }

    /**
     * Get the item stock levels.
     * @return HasMany
     */
    public function itemStockLevels(): HasMany
    {
        return $this->hasMany(ItemStockLevel::class);
    }

    /**
     * Get the stock entries associated with the item.
     */
    public function stockEntries(): HasMany
    {
        return $this->hasMany(StockEntry::class, 'item_id', 'id');
    }

    /**
     * Scope to get the default uom id of an item.
     *
     * @param  Builder  $query
     * @param  int  $itemId
     * @return int
     */
    public function scopeDefaultUomId($query, $itemId): int
    {
        return $query->where('id', $itemId)->value('default_uom_id');
    }
}
