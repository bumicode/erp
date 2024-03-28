<?php

namespace App\Observers\Selling;

use App\Models\CRM\Address;
use App\Models\Selling\Customer;
use Illuminate\Support\Facades\Log;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {

    }

    public function updating(Customer $customer): void
    {

    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
