<?php

namespace App\Models\Selling;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';

    protected $fillable = [
        'series',
        'status',
        'posting_date',
        'valid_upto',
        'order_type',
        'total_qty',
        'total_net_weight',
        'total_amount',
        'tax_category',
        'sales_tax_charge_template',
        'total_tax_charge',
        'grand_total',
        'rounding_adjustment',
        'rounded_total',
    ];

    public function customer(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'quotationables');
    }
}
