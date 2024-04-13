<?php

namespace App\Models\Selling;

use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use App\Models\CRM\Salutation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Wildside\Userstamps\Userstamps;

class Customer extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
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

    /**
     * Get the group associated with the customer
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    /**
     * Get the territory associated with the customer
     */
    public function territory(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }

    /**
     * Get the manager associated with the customer
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    /**
     * Get the addresses associated with the customer
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    /**
     * Get the contacts associated with the customer
     */
    public function contacts(): MorphToMany
    {
        return $this->morphToMany(Contact::class, 'contactable');
    }

    /**
     * Get the primary address associated with the customer
     */
    public function primaryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'primary_address_id');
    }

    /**
     * Get the primary contact associated with the customer
     */
    public function primaryContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'primary_contact_id');
    }

    /**
     * Get the salutation associated with the customer
     */
    public function salutation(): BelongsTo
    {
        return $this->belongsTo(Salutation::class);
    }

    /**
     * Get the sales people associated with the customer
     */
    public function salesPeople(): HasMany
    {
        return $this->hasMany(CustomerSalesPerson::class);
    }

    /**
     * Scope a query to only include addresses of a specific type.
     *
     * @param  Builder  $query
     * @param  string|array  $types
     * @return Builder
     */
    public function scopeAddressesOfType($query, $types)
    {
        if (! is_array($types)) {
            $types = [$types];
        }

        return $query->whereHas('addresses', function ($query) use ($types) {
            $query->whereIn('address_type', $types);
        });
    }
}
