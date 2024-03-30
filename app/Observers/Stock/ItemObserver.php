<?php

namespace App\Observers\Stock;

use App\Models\Stock\Item;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        //
    }

    /**
     * Handle the Item "saving" event.
     */
    public function saving(Item $item): void
    {
        if (empty($item->name)) {
            $item->name = $item->code;
        }

        if ($item->active) {
            if ($item->has_variant) {
                $item->status = 'template';
            } elseif ($item->parent_id !== null) {
                $item->status = 'variant';
            } else {
                $item->status = 'enabled';
            }
        } else {
            $item->status = 'disabled';
        }
    }

    /**
     * Handle the Item "saved" event.
     */
    public function saved(Item $item): void
    {
        if (! $item->maintain_stock && $item->itemInventory) {
            $item->itemInventory->delete();
        }
    }
}
