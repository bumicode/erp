<?php

namespace App\Models\Selling;

use App\Models\Accounting\PaymentTermTemplates;
use App\Models\Stock\PriceList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_group',
        'parent_id',
        'default_price_list_id',
        'default_payment_terms_template',
    ];

    public function parent()
    {
        return $this->belongsTo(CustomerGroup::class, 'parent_id');
    }

    public function defaultPriceList()
    {
        return $this->belongsTo(PriceList::class, 'default_price_list_id');
    }

    public function defaultPaymentTermsTemplate()
    {
        return $this->belongsTo(PaymentTermTemplates::class, 'default_payment_terms_template');
    }
}
