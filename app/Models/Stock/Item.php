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
        return $this->belongsTo(Uom::class);
    }
}
