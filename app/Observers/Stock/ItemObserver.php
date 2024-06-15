<?php

namespace App\Observers\Stock;

use App\Exceptions\MissingAttributeException;
use App\Models\Stock\Item;
use App\Models\Stock\ItemPrice;
use App\Models\Stock\ItemPriceList;
use App\Models\Stock\ItemUom;
use App\Models\Stock\StockEntry;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ItemObserver
{
    /**
     * Handle the Item "creating" event.
     *
     * @throws MissingAttributeException
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
     *
     * @throws MissingAttributeException
     * @throws Exception
     */
    public function created(Item $item): void
    {
        try {
            DB::beginTransaction();

            $this->createItemPrice($item, 1, $item->standard_selling_rate);
            $this->createItemPrice($item, 2, $item->standard_buying_rate);

            if ($item->maintain_stock) {
                $this->createStockEntry($item);
            }

            $this->createItemUoms($item);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $item->delete();
            throw $exception;
        }
    }

    /**
     * Handle the Item "updated" event.
     *
     * @throws Exception
     */
    public function updated(Item $item): void
    {
        try {
            DB::beginTransaction();

            $this->updateDefaultItemUoms($item);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
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
    private function createItemPrice(Item $item, int $priceListId, $standardRate): ?int
    {
        $priceList = ItemPriceList::find($priceListId);

        if (! $priceList) {
            return null;
        }

        $currencyId = $priceList->currency_id;
        $isSelling = $priceList->is_selling;
        $isBuying = $priceList->is_buying;

        $itemPrice = ItemPrice::create([
            'item_id' => $item->id,
            'uom_id' => $item->default_uom_id,
            'price_list_id' => $priceListId,
            'is_selling' => $isSelling,
            'is_buying' => $isBuying,
            'currency_id' => $currencyId,
            'rate' => $standardRate,
        ]);

        return $itemPrice->id;
    }

    /**
     * Create item stock entry.
     *
     * @throws MissingAttributeException
     */
    private function createStockEntry(Item $item): void
    {
        $totalRate = $item->opening_stock * $item->standard_selling_rate;

        $stockEntry = new StockEntry();
        $stockEntry->status = 'submitted';
        $stockEntry->series = StockEntry::generateNumber();
        $stockEntry->stock_entry_type_id = 2;
        $stockEntry->is_inspection_required = true;
        $stockEntry->posting_at = now();
        $stockEntry->items = [[
            'source_warehouse_id' => null,
            'target_warehouse_id' => '2',
            'item_id' => $item->id,
            'quantity' => $item->opening_stock,
            'basic_rate' => $item->standard_selling_rate,
            'total_rate' => $totalRate,
        ]];
        $stockEntry->total_outgoing = 0;
        $stockEntry->total_incoming = $totalRate;
        $stockEntry->total_value = $totalRate;
        $stockEntry->additional_costs = [];
        $stockEntry->total_additional_cost = 0;
        $stockEntry->save();
    }

    /**
     * Create item uoms.
     *
     * @return void
     */
    private function createItemUoms(Item $item)
    {
        $existingItemUom = ItemUom::where('item_id', $item->id)
            ->where('uom_id', $item->default_uom_id)
            ->first();

        if (! $existingItemUom) {
            $itemUomConversion = new ItemUom();
            $itemUomConversion->is_default = true;
            $itemUomConversion->item_id = $item->id;
            $itemUomConversion->uom_id = $item->default_uom_id;
            $itemUomConversion->conversion_rate = 1;
            $itemUomConversion->save();
        }
    }

    /**
     * Update item uoms.
     *
     * @return void
     */
    private function updateDefaultItemUoms(Item $item)
    {
        $existingItemUoms = ItemUom::where('item_id', $item->id)->get();

        $foundDefault = false; // Flag to track if default item uom is found

        foreach ($existingItemUoms as $existingItemUom) {
            if ($existingItemUom->uom_id == $item->default_uom_id) {
                if (! $existingItemUom->is_default) {
                    $existingItemUom->update([
                        'is_default' => true,
                    ]);
                }

                $foundDefault = true;
            } else {
                // If not default uom, set is_default to false
                $existingItemUom->update([
                    'is_default' => false,
                ]);
            }
        }

        // If default item uom not found, create a new one
        if (! $foundDefault) {
            // First, set all existing item uoms to non-default
            foreach ($existingItemUoms as $existingItemUom) {
                $existingItemUom->update([
                    'is_default' => false,
                ]);
            }

            // Then, create a new default item uom
            $itemUomConversion = new ItemUom();
            $itemUomConversion->is_default = true;
            $itemUomConversion->item_id = $item->id;
            $itemUomConversion->uom_id = $item->default_uom_id;
            $itemUomConversion->conversion_rate = 1;
            $itemUomConversion->save();
        }

        Notification::make()
            ->warning()
            ->title("You've successfully updated the default UOM. Please update the conversion rate in the Inventory tab.")
            ->send();
    }
}
