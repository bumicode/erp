<?php

namespace App\Observers\CRM;

use App\Models\CRM\Address;
use App\Models\Stock\Warehouse;
use Illuminate\Support\Facades\DB;

class AddressObserver
{
    /**
     * Handle the Address "created" event.
     */
    public function created(Address $address): void
    {

    }

    /**
     * Handle the Address "updated" event.
     */
    public function updated(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "deleted" event.
     */
    public function deleted(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "restored" event.
     */
    public function restored(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "force deleted" event.
     */
    public function forceDeleted(Address $address): void
    {
        //
    }

    /**
     * Handle the address "updating" event.
     *
     * @param  \App\Models\Address  $address
     * @return void
     */
    public function updating(Address $address): void
    {

    }
}
