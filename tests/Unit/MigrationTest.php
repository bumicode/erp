<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_table_has_expected_columns()
    {
        // Menjalankan migrasi
        $this->artisan('migrate');

        // Memeriksa apakah tabel users ada di database
        $this->assertTrue(Schema::hasTable('users'));

        // Memeriksa apakah tabel users memiliki kolom id, name, dan timestamps
        $this->assertTrue(Schema::hasColumns('users', [
            'id', 'name', 'created_at', 'updated_at',
        ]));
    }
}
