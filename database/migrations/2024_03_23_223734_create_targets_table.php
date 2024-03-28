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


        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_group_target_id')->unsigned()->nullable();
            $table->bigInteger('fiscal_year_id')->unsigned()->nullable();
            $table->integer('target_qty')->default(0);
            $table->bigInteger('target_amount')->default(0);
            $table->bigInteger('target_distribution_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
            // Add foreign key constraints for other reference fields if available
            // $table->foreign('item_group_target_id')->references('id')->on('item_group_targets');
            // $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years');
            // $table->foreign('target_distribution_id')->references('id')->on('target_distributions');
        });

        Schema::create('targetables', function (Blueprint $table) {
            $table->foreignId('target_id');
            $table->morphs('targetable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
        Schema::dropIfExists('targetables');
    }
};
