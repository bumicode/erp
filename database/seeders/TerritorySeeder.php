<?php

namespace Database\Seeders;

use App\Models\Selling\Territory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allTerritory = Territory::create([
            'name' => 'All Territories',
            'parent_id' => null,
            'territory_manager_id' => null,
        ]);

        Territory::create([
            'name' => 'Indonesia',
            'parent_id' => $allTerritory->id,
            'territory_manager_id' => null,
        ]);

        Territory::create([
            'name' => 'Rest Of The World',
            'parent_id' => $allTerritory->id,
            'territory_manager_id' => null,
        ]);
    }
}
