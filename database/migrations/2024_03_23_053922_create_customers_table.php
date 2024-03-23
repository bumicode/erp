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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('customer_group_id');
            $table->foreign('customer_group_id')->references('id')->on('customer_groups');
            $table->unsignedBigInteger('default_company_bank_account')->nullable();
            $table->enum('customer_type', ['Individual', 'Corporate'])->default('Individual');
            $table->unsignedBigInteger('territory_id');
            $table->foreign('territory_id')->references('id')->on('territories');
            $table->unsignedBigInteger('account_manager_id');
            $table->foreign('account_manager_id')->references('id')->on('users');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->boolean('allow_sales_invoice_creation_without_sales_order')->default(false);
            $table->boolean('allow_sales_invoice_creation_without_delivery_note')->default(false);
            $table->boolean('is_internal_customer')->default(false);
            $table->boolean('status')->default(true);
//            $table->unsignedBigInteger('from_lead_id')->nullable();
//            $table->foreign('from_lead_id')->references('id')->on('leads');
//            $table->unsignedBigInteger('from_opportunity')->nullable();
//            $table->foreign('from_opportunity')->references('id')->on('opportunities');
//            $table->unsignedBigInteger('primary_contact_id')->nullable();
//            $table->foreign('primary_contact_id')->references('id')->on('contactables');
//            $table->unsignedBigInteger('primary_address_id')->nullable();
//            $table->foreign('primary_address_id')->references('id')->on('addressables');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
