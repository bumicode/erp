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
        $custs = $customer->with('addresses')->find($customer->id);

        if (! $custs) {
            return;
        }

        try {
            foreach ($custs->addresses as $address) {
                if ($address->pivot->addressable_type === Customer::class
                    && $address->pivot->addressable_id !== $custs->primary_address_id) {
                    Address::find($address->id)->update([
                        'is_preferred_billing_address' => false,
                        'is_preferred_shipping_address' => false,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error occurred: '.$e->getMessage());
        }
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
