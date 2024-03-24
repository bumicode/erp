<?php

namespace App\Models\Selling;

use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use App\Models\CRM\Salutation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'salutation_id',
        'customer_group_id',
        'default_company_bank_account',
        'customer_type',
        'territory_id',
        'account_manager_id',
        'gender',
        'allow_sales_invoice_creation_without_sales_order',
        'allow_sales_invoice_creation_without_delivery_note',
        'is_internal_customer',
        'status',
        'marital_status',
        'market_segment_id',
        'industry_id',
        'website',
        'details',
        'company_address',
        'company_phone',
        'industry',
        'tax_id',
        'tax_category_id',
        'tax_withholding_category_id',
        'currency_id',
        'primary_address_id',
        'primary_contact_id',
        'from_lead_id',
        'from_opportunity',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    public function territory(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function contacts(): MorphToMany
    {
        return $this->morphToMany(Contact::class, 'contactable');
    }

    public function primaryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'primary_address_id');
    }

    public function salutation(): BelongsTo
    {
        return $this->belongsTo(Salutation::class);
    }
}
