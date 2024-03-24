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
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->boolean('allow_sales_invoice_creation_without_sales_order')->default(false);
            $table->boolean('allow_sales_invoice_creation_without_delivery_note')->default(false);
            $table->boolean('is_internal_customer')->default(false);
            $table->boolean('status')->default(true);
            $table->date('dob')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('industry')->nullable();
            //            $table->unsignedBigInteger('from_lead_id')->nullable();
            //            $table->foreign('from_lead_id')->references('id')->on('leads');
            //            $table->unsignedBigInteger('from_opportunity')->nullable();
            //            $table->foreign('from_opportunity')->references('id')->on('opportunities');
            //            $table->unsignedBigInteger('primary_contact_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->timestamp('interaction_date');
            $table->enum('interaction_type', ['Call', 'Email', 'Meeting', 'Other'])->default('Other');
            $table->text('interaction_details');
            $table->timestamps();
        });

        Schema::create('preference_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('preference_type_id')->constrained('preference_types')->cascadeOnDelete();
            $table->text('preference_value');
            $table->timestamps();
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->timestamp('feedback_date');
            $table->enum('feedback_type', ['Product', 'Service', 'General'])->default('General');
            $table->text('feedback_details');
            $table->integer('satisfaction_rating');
            $table->timestamps();
        });

        Schema::create('education_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('demographics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('country');
            $table->string('city');
            $table->integer('age');
            $table->decimal('annual_income', 10, 2);
            $table->foreignId('education_level_id')->constrained('education_levels')->nullOnDelete();
            $table->text('feedback_details');
            $table->integer('satisfaction_rating');
            $table->timestamps();
        });

        Schema::create('social_media_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('social_media_platform_id')->constrained('social_media_platforms')->nullOnDelete();
            $table->string('social_media_handle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('interactions');
        Schema::dropIfExists('preference_types');
        Schema::dropIfExists('preferences');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('education_levels');
        Schema::dropIfExists('demographics');
        Schema::dropIfExists('social_media_platforms');
        Schema::dropIfExists('social_media');
    }
};
