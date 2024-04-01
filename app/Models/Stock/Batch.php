<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Batch extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'batches';

    protected $fillable = [
        'batch_id',
        'status',
        'use_batch_wise_valuation',
        'item_id',
        'uom_id',
        'expiry_date',
        'manufacture_date',
        'description',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function uom()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'uom_id');
    }
}
