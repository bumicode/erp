<?php

namespace App\Observers\Stock;

use App\Models\Stock\Item;
use App\Models\Stock\ItemStockLevel;
use App\Models\Stock\StockEntry;

class StockEntryObserver
{
    /*
     * Handle the StockEntry "creating" event.
     */
    public function creating(StockEntry $stockEntry): void
    {
        $series = StockEntry::generateNumber();
        $stockEntry->series = $series;
    }

    /**
     * Handle the StockEntry "created" event.
     */
    public function created(StockEntry $stockEntry): void
    {
        $this->updateItemStockLevels($stockEntry);
    }

    /**
     * Handle the StockEntry "updated" event.
     */
    public function updated(StockEntry $stockEntry): void
    {
        $this->updateItemStockLevels($stockEntry);
    }

    /**
     * Handle the StockEntry "deleted" event.
     */
    public function deleted(StockEntry $stockEntry): void
    {
        //
    }

    /**
     * Handle the StockEntry "restored" event.
     */
    public function restored(StockEntry $stockEntry): void
    {
        //
    }

    /**
     * Handle the StockEntry "force deleted" event.
     */
    public function forceDeleted(StockEntry $stockEntry): void
    {
        //
    }

    /*
     * Update item stock levels based on the stock entry items.
     */
    private function updateItemStockLevels(StockEntry $stockEntry): void
    {
        $items = $stockEntry->items;

        foreach ($items as $item) {
            $defaultUomId = Item::defaultUomId($item['item_id']);

            $existingItemStock = ItemStockLevel::where('item_id', $item['item_id'])
                ->where('warehouse_id', $item['target_warehouse_id'])
                ->first();

            if ($existingItemStock) {
                // Update existing item stock level
                $existingItemStock->stock += $item['quantity'];
                $existingItemStock->save();
            } else {
                // Create new item stock level
                ItemStockLevel::create([
                    'item_id' => $item['item_id'],
                    'uom_id' => $defaultUomId,
                    'stock' => $item['quantity'],
                    'warehouse_id' => $item['target_warehouse_id'],
                ]);
            }
        }
    }
}
