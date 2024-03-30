<?php

namespace Database\Seeders\Stock;

use App\Models\Stock\ItemGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allItemGroups = ItemGroup::create([
            'is_group' => true,
            'name' => 'All Item Groups',
            'parent_id' => null,
        ]);

        ItemGroup::create([
            'is_group' => false,
            'name' => 'Consumable',
            'parent_id' => $allItemGroups->id,
        ]);

        ItemGroup::create([
            'is_group' => false,
            'name' => 'Products',
            'parent_id' => $allItemGroups->id,
        ]);

        ItemGroup::create([
            'is_group' => false,
            'name' => 'Raw Material',
            'parent_id' => $allItemGroups->id,
        ]);

        ItemGroup::create([
            'is_group' => false,
            'name' => 'Services',
            'parent_id' => $allItemGroups->id,
        ]);

        ItemGroup::create([
            'is_group' => false,
            'name' => 'Sub Assemblies',
            'parent_id' => $allItemGroups->id,
        ]);
    }
}
