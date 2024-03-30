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
            ['name' => 'Nos', 'abbreviation' => 'nos'],         // Potong
            ['name' => 'Piece', 'abbreviation' => 'pcs'],         // Potong
            ['name' => 'Kilogram', 'abbreviation' => 'kg'],      // Kilogram
            ['name' => 'Meter', 'abbreviation' => 'm'],         // Meter
            ['name' => 'Liter', 'abbreviation' => 'L'],         // Liter
            ['name' => 'Box', 'abbreviation' => 'box'],           // Kotak
            ['name' => 'Dozen', 'abbreviation' => 'dz'],         // Lusin
            ['name' => 'Pack', 'abbreviation' => 'pack'],          // Paket
            ['name' => 'Carton', 'abbreviation' => 'ctn'],        // Karton
            ['name' => 'Pallet', 'abbreviation' => 'plt'],        // Palet
            ['name' => 'Roll', 'abbreviation' => 'roll'],          // Gulung
            ['name' => 'Set', 'abbreviation' => 'set'],           // Set
            ['name' => 'Gram', 'abbreviation' => 'g'],          // Gram
            ['name' => 'Millimeter', 'abbreviation' => 'mm'],    // Milimeter
            ['name' => 'Centimeter', 'abbreviation' => 'cm'],    // Sentimeter
            ['name' => 'Inch', 'abbreviation' => 'in'],          // Inci
            ['name' => 'Foot', 'abbreviation' => 'ft'],          // Kaki
            ['name' => 'Yard', 'abbreviation' => 'yd'],          // Yard
            ['name' => 'Hour', 'abbreviation' => 'hr'],          // Jam
            ['name' => 'Day', 'abbreviation' => 'day'],           // Hari
            ['name' => 'Week', 'abbreviation' => 'wk'],          // Minggu
            ['name' => 'Month', 'abbreviation' => 'mo'],         // Bulan
            ['name' => 'Year', 'abbreviation' => 'yr'],          // Tahun
            // Add more commonly used UOMs as needed
        ];

        foreach ($uoms as $uom) {
            \App\Models\Stock\UnitOfMeasure::create($uom);
        }
    }
}
