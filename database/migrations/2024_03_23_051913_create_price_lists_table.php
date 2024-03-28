<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->boolean('status')->default(true);
            $table->string('fraction')->nullable();
            $table->string('fraction_units')->nullable();
            $table->double('smallest_currency_fraction_value')->default(0.00);
            $table->boolean('show_currency_symbol_on_right_side')->default(false);
            $table->enum('number_format', [
                '#,###.##',
                '#.###,##',
                '# ###,##',
                '#, ###.##',
                '#,##,###.##',
                '#,###.###',
                '#.###',
                '#,###',
            ])->nullable();
            $table->timestamps();
        });

        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('name');
            $table->foreignId('currency_id')->constrained('currencies')->nullOnDelete();
            $table->boolean('buying')->default(false);
            $table->boolean('selling')->default(false);
            $table->boolean('price_not_uom_dependent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_lists');
        Schema::dropIfExists('currencies');
    }
};
