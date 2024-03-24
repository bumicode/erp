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
        Schema::create('tax_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_preferred_billing_address')->default(false);
            $table->boolean('is_preferred_shipping_address')->default(false);
            $table->boolean('status')->default(true);
            $table->string('address_title');
            $table->enum('address_type', [
                'Billing',
                'Shipping',
                'Office',
                'Personal',
                'Plant',
                'Postal',
                'Shop',
                'Subsidiary',
                'Warehouse',
                'Current',
                'Permanent',
                'Other',
            ])->default('Billing');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
            $table->string('city_town');
            $table->string('county')->nullable();
            $table->string('state_province');
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('email_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedBigInteger('tax_category')->nullable();
            $table->foreign('tax_category')->references('id')->on('tax_categories');
            $table->timestamps();
        });

        Schema::create('addressables', function (Blueprint $table) {
            $table->foreignId('address_id');
            $table->morphs('addressable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('addressables');
    }
};
