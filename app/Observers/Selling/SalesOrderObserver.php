<?php

namespace App\Observers\Selling;

use App\Models\Selling\SalesOrder;

class SalesOrderObserver
{
    /**
     * Handle the SalesOrder "creating" event.
     */
    public function creating(SalesOrder $salesOrder): void
    {
        if (! $salesOrder->posting_date) {
            $salesOrder->posting_date = now();
        }
    }

    /**
     * Handle the SalesOrder "created" event.
     */
    public function created(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "updated" event.
     */
    public function updated(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "deleted" event.
     */
    public function deleted(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "restored" event.
     */
    public function restored(SalesOrder $salesOrder): void
    {
        //
    }

    /**
     * Handle the SalesOrder "force deleted" event.
     */
    public function forceDeleted(SalesOrder $salesOrder): void
    {
        //
    }
}
