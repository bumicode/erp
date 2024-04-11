<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Common\CountrySeeder;
use Database\Seeders\Common\CurrencySeeder;
use Database\Seeders\Common\TimezoneSeeder;
use Database\Seeders\CRM\SalutationSeed;
use Database\Seeders\Selling\CustomerGroupSeeder;
use Database\Seeders\Selling\TerritorySeeder;
use Database\Seeders\Stock\ItemGroupSeeder;
use Database\Seeders\Stock\ItemPriceListSeeder;
use Database\Seeders\Stock\StockEntryTypeSeeder;
use Database\Seeders\Stock\UomSeeder;
use Database\Seeders\Stock\WarehouseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);

        $this->call([
            CustomerGroupSeeder::class,
            TerritorySeeder::class,
            SalutationSeed::class,
            TimezoneSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            UomSeeder::class,
            ItemGroupSeeder::class,
            ItemPriceListSeeder::class,
            WarehouseSeeder::class,
            StockEntryTypeSeeder::class,
        ]);
    }
}
