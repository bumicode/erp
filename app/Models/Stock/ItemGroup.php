<?php

namespace App\Models\Stock;

use App\Traits\SelectableOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ItemGroup extends Model
{
    use HasFactory, SelectableOptions, Userstamps;

    protected $table = 'item_groups';

    protected $fillable = [
        'name',
        'parent_id',
        'is_group',
        'show_in_website',
        'created_by',
        'updated_by',
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ItemGroup::class, 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemGroup::class, 'parent_id');
    }
}
