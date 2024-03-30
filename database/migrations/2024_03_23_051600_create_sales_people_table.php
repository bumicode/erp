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
        Schema::create('sales_people', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_group')->default(false);
            $table->boolean('status')->default(true);
            $table->string('name');
            $table->unsignedBigInteger('employee')->nullable(); // Check your reference here, it's not specified
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('sales_people');
            $table->float('commission_rate')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_sales_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_person_id')->nullable()->constrained('sales_people')->cascadeOnDelete();
            $table->float('contribution')->default(0);
            $table->float('commission_rate')->nullable();
            $table->bigInteger('contribution_to_net_total')->nullable();
            $table->bigInteger('incentives')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_people');
        Schema::dropIfExists('customer_sales_person');
    }
};
