<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'series',
        'stock_entry_type_id',
        'is_inspection_required',
        'posting_at',
        'items',
        'total_outgoing',
        'total_incoming',
        'total_value',
        'additional_costs',
        'total_additional_cost',
    ];

    protected $casts = [
        'items' => 'array',
        'total_outgoing' => 'float',
        'total_incoming' => 'float',
        'total_value' => 'float',
        'additional_costs' => 'array',
        'total_additional_cost' => 'float',
    ];
}
