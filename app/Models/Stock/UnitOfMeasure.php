<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class UnitOfMeasure extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'uoms';

    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }
}
