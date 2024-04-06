<?php

namespace Database\Seeders\Stock;

use App\Models\Stock\ItemPriceList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemPriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemPriceList::create([
            'name' => 'Standard Selling',
            'is_selling' => true,
            'currency_id' => 13,
        ]);
        ItemPriceList::create([
            'name' => 'Standard Buying',
            'is_buying' => true,
            'currency_id' => 13,
        ]);
    }
}
