<?php

namespace App\Models\Selling;

use App\Models\Accounting\PaymentTermTemplates;
use App\Models\Stock\PriceList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class CustomerGroup extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $fillable = [
        'name',
        'is_group',
        'parent_id',
        'default_price_list_id',
        'default_payment_terms_template',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'parent_id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(CustomerGroup::class, 'parent_id');
    }

    public function defaultPriceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'default_price_list_id');
    }

    public function defaultPaymentTermsTemplate(): BelongsTo
    {
        return $this->belongsTo(PaymentTermTemplates::class, 'default_payment_terms_template');
    }
}
