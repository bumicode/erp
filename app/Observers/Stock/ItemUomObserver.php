<?php

namespace App\Observers\Stock;

use App\Models\Stock\Item;
use App\Models\Stock\ItemUom;
use Filament\Notifications\Notification;

class ItemUomObserver
{
    /**
     * Handle the ItemUomObserver "created" event.
     */
    public function created(ItemUom $itemUom): void
    {
        //
    }

    /**
     * Handle the ItemUomObserver "updated" event.
     */
    public function updated(ItemUom $itemUom): void
    {
        //
    }

    /**
     * Handle the item "deleting" event.
     */
    public function deleting(ItemUom $itemUom)
    {
        $item = Item::find($itemUom->item_id);

        if ($item->default_uom_id = $itemUom->is_default) {
            Notification::make()
                ->danger()
                ->title('UOM cannot be deleted because it is set as default in uom conversions.')
                ->send();

            return false;
        }
    }

    /**
     * Handle the ItemUomObserver "deleted" event.
     */
    public function deleted(ItemUom $itemUom): void
    {
        //
    }

    /**
     * Handle the ItemUomObserver "restored" event.
     */
    public function restored(ItemUom $itemUom): void
    {
        //
    }

    /**
     * Handle the ItemUomObserver "force deleted" event.
     */
    public function forceDeleted(ItemUom $itemUom): void
    {
        //
    }
}
