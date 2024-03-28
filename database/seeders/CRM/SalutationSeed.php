<?php

namespace Database\Seeders\CRM;

use App\Models\CRM\Salutation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalutationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salutations = [
            'Mr.',
            'Mrs.',
            'Ms.',
            'Dr.',
            'Prof.',
            'Rev.',
            'Madam',
            'Miss',
            'Master',
            'Sir',
            'Lord',
            'Lady',
            'Mx.',
        ];

        foreach ($salutations as $salutation) {
            Salutation::create([
                'name' => $salutation,
            ]);
        }
    }
}
