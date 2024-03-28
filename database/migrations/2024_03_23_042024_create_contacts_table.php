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

        Schema::create('salutations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_primary_contact')->default(false);
            $table->boolean('is_billing_contact')->default(false);
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->enum('status', ['Open', 'Replied', 'Passive'])->default('Passive');
            $table->foreignId('salutation_id')->nullable()->constrained('salutations')->nullOnDelete();
            $table->string('designation')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('company_name')->nullable();
            $table->timestamps();
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->boolean('is_primary_phone')->default(false);
            $table->boolean('is_primary_mobile')->default(false);
            $table->timestamps();
        });

        Schema::create('emailables', function (Blueprint $table) {
            $table->foreignId('email_id');
            $table->morphs('emailable');
        });

        Schema::create('phonenumberables', function (Blueprint $table) {
            $table->foreignId('phone_number_id');
            $table->morphs('phonenumberable');
        });

        Schema::create('contactables', function (Blueprint $table) {
            $table->foreignId('contact_id');
            $table->morphs('contactable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('emails');
        Schema::dropIfExists('phone_numbers');
        Schema::dropIfExists('emailables');
        Schema::dropIfExists('phonenumberables');
        Schema::dropIfExists('contactables');
        Schema::dropIfExists('salutations');
    }
};
