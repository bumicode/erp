<?php

namespace App\Models\Selling;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'customer_group_id',
        'default_company_bank_account',
        'customer_type',
        'territory_id',
        'account_manager_id',
        'gender',
        'allow_sales_invoice_creation_without_sales_order',
        'allow_sales_invoice_creation_without_delivery_note',
        'is_internal_customer',
        'is_disabled',
        'from_lead_id',
        'from_opportunity',
        'primary_contact_id',
        'primary_address_id',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    public function territory(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }
//
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

//    public function contact()
//    {
//        return $this->belongsTo(Contactable::class, 'primary_contact_id');
//    }
//
//    public function address()
//    {
//        return $this->belongsTo(Addressable::class, 'primary_address_id');
//    }

}
