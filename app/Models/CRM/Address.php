<?php

namespace App\Models\CRM;

use App\Models\Selling\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Wildside\Userstamps\Userstamps;

class Address extends Model
{
    use HasFactory, Userstamps;

    protected $table = 'addresses';

    protected $fillable = [
        'is_preferred_billing_address',
        'is_preferred_shipping_address',
        'is_disabled',
        'address_title',
        'address_type',
        'address_line_one',
        'address_line_two',
        'city_town',
        'county',
        'state_province',
        'country',
        'postal_code',
        'email_address',
        'phone',
        'fax',
        'tax_category_id',
    ];

    protected $casts = [
        'is_preferred_billing_address' => 'boolean',
        'is_preferred_shipping_address' => 'boolean',
        'is_disabled' => 'boolean',
    ];

    public function customers(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'addressable');
    }

    public function customer(): HasOne

    {
        return $this->hasOne(Customer::class);
    }
}
