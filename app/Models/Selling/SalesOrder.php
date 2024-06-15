<?php

namespace App\Models\Selling;

use App\Enums\Stock\SalesOrderStatus;
use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use App\Models\Stock\Item;
use App\Models\Stock\Warehouse;
use App\Traits\GeneratesUniqueNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class SalesOrder extends Model
{
    use GeneratesUniqueNumber, HasFactory, SoftDeletes, Userstamps;

    public static string $numberPrefix = 'SAL-ORD'; // set the desired prefix
    public static string $numberField = 'series'; // set the desired field name
    public static bool $withYear = true; // set true to include the year in the generated number

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'series',
        'status',
        'delivery_status',
        'billed_status',
        'posting_date',
        'delivery_date',
        'order_type',
        'items',
        'total_qty',
        'total_net_weight',
        'total_amount',
        'sales_taxes_and_charges',
        'total_tax_charge',
        'grand_total',
        'rounding_adjustment',
        'rounded_total',
        'advance_paid',
        'sales_tax_charge_template',
        'customer_id',
        'customer_billing_address_id',
        'customer_shipping_address_id',
        'customer_contact_id',
        'payment_terms_template_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'items' => 'json',
        'sales_taxes_and_charges' => 'json',
        'status' => SalesOrderStatus::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'posting_date',
        'delivery_date',
    ];

    /**
     * Get the customer associated with the sales order.
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the address associated with the sales order.
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the contact associated with the sales order.
     * @return BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the items associated with the stock entry.
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }

    /**
     * Get the warehouse associated with the sales order.
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
