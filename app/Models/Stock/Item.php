<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

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
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function childrens(): HasMany
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function itemGroup(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function defaultUom(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    public function itemInventory(): HasOne
    {
        return $this->hasOne(ItemInventory::class);
    }

    public function conversions()
    {
        return $this->morphMany(Conversion::class, 'convertible');
    }
}
