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

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_alpha_2', 2);
            $table->string('iso_alpha_3', 3);
            $table->string('iso_numeric', 3);
            $table->string('calling_code');
            $table->string('date_format')->nullable();
            $table->string('time_format')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
        });

        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->string('name');
            $table->string('offset');
            $table->string('offset_hours');
            $table->string('offset_minutes');
            $table->timestamps();
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
        });

        Schema::create('countryables', function (Blueprint $table) {
            $table->foreignId('country_id');
            $table->morphs('countryable');
        });

        Schema::create('market_segments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tax_withholding_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // More Columns
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('salutation_id')->nullable()->constrained('salutations')->nullOnDelete();
            $table->unsignedBigInteger('customer_group_id');
            $table->foreign('customer_group_id')->references('id')->on('customer_groups');
            $table->unsignedBigInteger('default_company_bank_account')->nullable();
            $table->enum('customer_type', ['Individual', 'Corporate'])->default('Individual');
            $table->unsignedBigInteger('territory_id');
            $table->foreign('territory_id')->references('id')->on('territories');
            $table->foreignId('account_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->boolean('allow_sales_invoice_creation_without_sales_order')->default(false);
            $table->boolean('allow_sales_invoice_creation_without_delivery_note')->default(false);
            $table->boolean('is_internal_customer')->default(false);
            $table->boolean('status')->default(true);
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->foreignId('market_segment_id')->nullable()->constrained('market_segments')->nullOnDelete();
            $table->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete();
            $table->string('website')->nullable();
            $table->text('details')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('industry')->nullable();
            $table->string('tax_id')->nullable();
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
            $table->foreignId('tax_withholding_category_id')->nullable()
                ->constrained('tax_withholding_categories')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->foreignId('primary_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('primary_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->unsignedBigInteger('from_lead_id')->nullable();
            $table->foreign('from_lead_id')->references('id')->on('leads');
            $table->unsignedBigInteger('from_opportunity')->nullable();
            $table->foreign('from_opportunity')->references('id')->on('opportunities');
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

        Schema::create('feedbacks', function (Blueprint $table) {
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

        Schema::create('social_medias', function (Blueprint $table) {
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
        Schema::dropIfExists('timezones');
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
        });
        Schema::dropIfExists('countries');
        Schema::dropIfExists('countryables');
        Schema::dropIfExists('interactions');
        Schema::dropIfExists('preferences');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('demographics');
        Schema::dropIfExists('social_medias');
        Schema::dropIfExists('education_levels');
        Schema::dropIfExists('preference_types');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('social_media_platforms');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('opportunities');
        Schema::dropIfExists('market_segments');
        Schema::dropIfExists('industries');
        Schema::dropIfExists('tax_withholding_categories');
    }
};
