<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Territory extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'parent_id',
        'name',
        'territory_manager_id',
    ];

    public function manager()
    {
        return $this->belongsTo(SalesPerson::class, 'territory_manager_id');
    }

    public function parent()
    {
        return $this->belongsTo(Territory::class, 'parent_id');
    }

}
