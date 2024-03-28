<?php

namespace Database\Seeders;

use App\Models\Selling\CustomerGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allCustomerGroups = CustomerGroup::create([
            'is_group' => true,
            'name' => 'All Customer Groups',
            'parent_id' => null,
            'default_price_list_id' => null,
            'default_payment_terms_template' => null,
        ]);

        CustomerGroup::create([
            'is_group' => false,
            'name' => 'Commercial',
            'parent_id' => $allCustomerGroups->id,
            'default_price_list_id' => null,
            'default_payment_terms_template' => null,
        ]);

        CustomerGroup::create([
            'is_group' => false,
            'name' => 'Government',
            'parent_id' => $allCustomerGroups->id,
            'default_price_list_id' => null,
            'default_payment_terms_template' => null,
        ]);

        CustomerGroup::create([
            'is_group' => false,
            'name' => 'Individual',
            'parent_id' => $allCustomerGroups->id,
            'default_price_list_id' => null,
            'default_payment_terms_template' => null,
        ]);

        CustomerGroup::create([
            'is_group' => false,
            'name' => 'Non Profit',
            'parent_id' => $allCustomerGroups->id,
            'default_price_list_id' => null,
            'default_payment_terms_template' => null,
        ]);
    }
}
