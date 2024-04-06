<?php

namespace Database\Seeders\Stock;

use App\Models\Stock\Warehouse;
use App\Models\Stock\WarehouseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouseType = WarehouseType::create([
            'name' => 'Transit',
            'description' => 'Transit Warehouse',
        ]);

        $allWarehouseGroups = Warehouse::create([
            'is_group' => true,
            'name' => 'All Warehouses',
            'parent_id' => null,
        ]);

        Warehouse::create([
            'is_group' => false,
            'name' => 'Stores',
            'parent_id' => $allWarehouseGroups->id,
        ]);

        Warehouse::create([
            'is_group' => false,
            'name' => 'Goods In Transit',
            'warehouse_type_id' => $warehouseType->id,
            'parent_id' => $allWarehouseGroups->id,
        ]);

        Warehouse::create([
            'is_group' => false,
            'name' => 'Finished Goods',
            'parent_id' => $allWarehouseGroups->id,
        ]);

        Warehouse::create([
            'is_group' => false,
            'name' => 'Work In Progress',
            'parent_id' => $allWarehouseGroups->id,
        ]);
    }
}
