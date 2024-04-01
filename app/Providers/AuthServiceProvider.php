<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Accounting\PaymentTermTemplates;
use App\Models\Accounting\SalesInvoice;
use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use App\Models\Selling\Customer;
use App\Models\Selling\CustomerGroup;
use App\Models\Selling\Quotation;
use App\Models\Selling\SalesOrder;
use App\Models\Selling\SalesPerson;
use App\Models\Selling\Target;
use App\Models\Selling\Territory;
use App\Models\Stock\Item;
use App\Models\Stock\ItemGroup;
use App\Models\Stock\PriceList;
use App\Policies\Accounting\PaymentTermTemplatesPolicy;
use App\Policies\Accounting\SalesInvoicePolicy;
use App\Policies\CRM\AddressPolicy;
use App\Policies\CRM\ContactPolicy;
use App\Policies\Selling\CustomerGroupPolicy;
use App\Policies\Selling\CustomerPolicy;
use App\Policies\Selling\QuotationPolicy;
use App\Policies\Selling\SalesOrderPolicy;
use App\Policies\Selling\SalesPersonPolicy;
use App\Policies\Selling\TargetPolicy;
use App\Policies\Selling\TerritoryPolicy;
use App\Policies\Stock\ItemGroupPolicy;
use App\Policies\Stock\ItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        /*
         * Accounting Model Policy
         */
        PaymentTermTemplates::class => PaymentTermTemplatesPolicy::class,
        SalesInvoice::class => SalesInvoicePolicy::class,

        /*
         * Buying Model Policy
         */

        /*
         * CRM Model Policy
         */
        Address::class => AddressPolicy::class,
        Contact::class => ContactPolicy::class,

        /*
         * Selling Model Policy
         */
        Customer::class => CustomerPolicy::class,
        CustomerGroup::class => CustomerGroupPolicy::class,
        Quotation::class => QuotationPolicy::class,
        SalesOrder::class => SalesOrderPolicy::class,
        SalesPerson::class => SalesPersonPolicy::class,
        Target::class => TargetPolicy::class,
        Territory::class => TerritoryPolicy::class,

        /*
         * Stock Model Policy
         */
        Item::class => ItemPolicy::class,
        ItemGroup::class => ItemGroupPolicy::class,
        PriceList::class => PriceList::class,

        /**
         * Activity Log Policy
         */
        Activity::class => ActivityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
