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
        Schema::create('stock_entry_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('purpose', [
                'material issue',
                'material receipt',
                'material transfer',
                'material transfer for manufacture',
                'material consumption for manufacture',
                'manufacture',
                'repack',
                'send to subcontractor',
            ]);
            $table->timestamps();
        });

        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->string('series')->unique();
            $table->enum('status', ['draft', 'submitted', 'canceled'])->default('draft');
            $table->foreignId('stock_entry_type_id')->constrained('stock_entry_types')->nullOnDelete();
            $table->boolean('is_inspection_required')->default(false);
            $table->timestamp('posting_at');
            $table->json('items');
            $table->float('total_outgoing');
            $table->float('total_incoming');
            $table->float('total_value');
            $table->json('additional_costs');
            $table->float('total_additional_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
        Schema::dropIfExists('stock_entry_types');
    }
};
