<?php

namespace App\Observers\CRM;

use App\Models\CRM\Contact;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact): void
    {
        //
    }

    /**
     * @return void
     *              Handle the Contact "saving" event.
     */
    public function saving(Contact $contact): void
    {
        $contact->full_name = $contact->getFullNameAttribute();
    }

    /**
     * Handle the Contact "updated" event.
     */
    public function updated(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     */
    public function deleted(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     */
    public function restored(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     */
    public function forceDeleted(Contact $contact): void
    {
        //
    }
}
