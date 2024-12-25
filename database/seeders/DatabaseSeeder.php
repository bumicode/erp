<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $org = \App\Models\TenantOrganization::firstOrCreate(
            [
                'name' => 'BUMICODE',
                'slug' => 'bumicode',
            ]
        );

        $adminUser = \App\Models\User::firstOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Admin',
                'tenant_organization_id' => $org->id,
                'is_superuser' => true,
                'password' => bcrypt('admin'),
            ]
        );
    }
}
