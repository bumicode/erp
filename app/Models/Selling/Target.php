<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Target extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $table = 'targets';

    protected $fillable = [
        'item_group_target_id',
        'fiscal_year_id',
        'target_qty',
        'target_amount',
        'target_distribution_id',
    ];

    public function salesPerson(): MorphToMany
    {
        return $this->morphedByMany(SalesPerson::class, 'targetable');
    }
}
