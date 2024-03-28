<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Common\CountrySeeder;
use Database\Seeders\Common\CurrencySeeder;
use Database\Seeders\Common\TimezoneSeeder;
use Database\Seeders\CRM\SalutationSeed;
use Database\Seeders\Selling\CustomerGroupSeeder;
use Database\Seeders\Selling\TerritorySeeder;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CustomerGroupSeeder::class,
            TerritorySeeder::class,
            SalutationSeed::class,
            TimezoneSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
        ]);
    }
}
