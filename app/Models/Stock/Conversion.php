<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Conversion extends Model
{
    use HasFactory, Userstamps;

    public function convertible()
    {
        return $this->morphTo();
    }

    public function uom()
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }
}
