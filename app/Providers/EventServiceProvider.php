<?php

namespace App\Providers;

use App\Models\CRM\Address;
use App\Models\CRM\Contact;
use App\Models\Selling\Customer;
use App\Models\Selling\SalesOrder;
use App\Models\Stock\Item;
use App\Models\Stock\ItemUom;
use App\Models\Stock\StockEntry;
use App\Models\Stock\Warehouse;
use App\Observers\CRM\AddressObserver;
use App\Observers\CRM\ContactObserver;
use App\Observers\Selling\CustomerObserver;
use App\Observers\Selling\SalesOrderObserver;
use App\Observers\Stock\ItemObserver;
use App\Observers\Stock\ItemUomObserver;
use App\Observers\Stock\StockEntryObserver;
use App\Observers\Stock\WarehouseObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Common model observer
         */
        Address::observe(AddressObserver::class);
        Contact::observe(ContactObserver::class);

        /**
         * Selling model observer
         */
        Customer::observe(CustomerObserver::class);
        SalesOrder::observe(SalesOrderObserver::class);

        /**
         * Stock model observer
         */
        Item::observe(ItemObserver::class);
        ItemUom::observe(ItemUomObserver::class);
        Warehouse::observe(WarehouseObserver::class);
        StockEntry::observe(StockEntryObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
