<?php

namespace Database\Seeders\Stock;

use App\Models\Stock\StockEntryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockEntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockEntryTypes = [
            ['name' => 'Material Issue', 'purpose' => 'material issue'],
            ['name' => 'Material Receipt', 'purpose' => 'material receipt'],
            ['name' => 'Material Transfer', 'purpose' => 'material transfer'],
            ['name' => 'Material Transfer for Manufacture', 'purpose' => 'material transfer for manufacture'],
            ['name' => 'Material Consumption for Manufacture', 'purpose' => 'material consumption for manufacture'],
            ['name' => 'Manufacture', 'purpose' => 'manufacture'],
            ['name' => 'Repack', 'purpose' => 'repack'],
            ['name' => 'Send to Subcontractor', 'purpose' => 'send to subcontractor'],
        ];

        foreach ($stockEntryTypes as $stockEntryType) {
            StockEntryType::create($stockEntryType);
        }
    }
}
