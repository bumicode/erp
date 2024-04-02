<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class PriceList extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'name',
        'is_buying',
        'is_selling',
    ];
}
