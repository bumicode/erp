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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
