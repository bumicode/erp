<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SalesPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_group',
        'status',
        'name',
        'employee',
        'parent_id',
        'commission_rate',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SalesPerson::class, 'parent_id');
    }

    public function childrens(): HasMany
    {
        return $this->hasMany(SalesPerson::class, 'parent_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
