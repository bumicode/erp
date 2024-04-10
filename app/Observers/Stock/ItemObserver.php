<?php

namespace App\Observers\Stock;

use App\Models\Stock\Item;
use App\Models\Stock\ItemPrice;
use App\Models\Stock\ItemPriceList;

class ItemObserver
{
    /**
     * Handle the Item "creating" event.
     */
    public function creating(Item $item): void
    {
        if (empty($item->code)) {
            $code = Item::generateNumber();
            $item->code = $code;
        }
    }

    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        $this->createItemPrice($item, 1, $item->standard_selling_rate);
        $this->createItemPrice($item, 2, $item->standard_buying_rate);
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

    /**
     * Create an item price entry.
     */
    private function createItemPrice(Item $item, int $priceListId, $standardRate): void
    {
        $priceList = ItemPriceList::find($priceListId);

        if (! $priceList) {
            return;
        }

        $currencyId = $priceList->currency_id;
        $isSelling = $priceList->is_selling;
        $isBuying = $priceList->is_buying;

        ItemPrice::create([
            'item_id' => $item->id,
            'uom_id' => $item->default_uom_id,
            'price_list_id' => $priceListId,
            'is_selling' => $isSelling,
            'is_buying' => $isBuying,
            'currency_id' => $currencyId,
            'rate' => $standardRate,
        ]);
    }
}
