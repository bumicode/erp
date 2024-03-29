<?php

namespace Database\Seeders\Stock;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uoms = [
            ['name' => 'Piece', 'symbol' => 'pcs'],         // Potong
            ['name' => 'Kilogram', 'symbol' => 'kg'],      // Kilogram
            ['name' => 'Meter', 'symbol' => 'm'],         // Meter
            ['name' => 'Liter', 'symbol' => 'L'],         // Liter
            ['name' => 'Box', 'symbol' => 'box'],           // Kotak
            ['name' => 'Dozen', 'symbol' => 'dz'],         // Lusin
            ['name' => 'Pack', 'symbol' => 'pack'],          // Paket
            ['name' => 'Carton', 'symbol' => 'ctn'],        // Karton
            ['name' => 'Pallet', 'symbol' => 'plt'],        // Palet
            ['name' => 'Roll', 'symbol' => 'roll'],          // Gulung
            ['name' => 'Set', 'symbol' => 'set'],           // Set
            ['name' => 'Gram', 'symbol' => 'g'],          // Gram
            ['name' => 'Millimeter', 'symbol' => 'mm'],    // Milimeter
            ['name' => 'Centimeter', 'symbol' => 'cm'],    // Sentimeter
            ['name' => 'Inch', 'symbol' => 'in'],          // Inci
            ['name' => 'Foot', 'symbol' => 'ft'],          // Kaki
            ['name' => 'Yard', 'symbol' => 'yd'],          // Yard
            ['name' => 'Hour', 'symbol' => 'hr'],          // Jam
            ['name' => 'Day', 'symbol' => 'day'],           // Hari
            ['name' => 'Week', 'symbol' => 'wk'],          // Minggu
            ['name' => 'Month', 'symbol' => 'mo'],         // Bulan
            ['name' => 'Year', 'symbol' => 'yr'],          // Tahun
            // Add more commonly used UOMs as needed
        ];

        foreach ($uoms as $uom) {
            \App\Models\Stock\Uom::create($uom);
        }
    }
}
