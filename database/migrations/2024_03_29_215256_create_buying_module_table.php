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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('supplier_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('supplier_groups')->nullOnDelete();
            $table->boolean('is_group')->default(false);
            $table->foreignId('default_payment_terms_template_id')
                ->nullable()
                ->constrained('payment_terms_templates')
                ->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('supplier_group_id')->constrained('supplier_groups')->cascadeOnDelete();
            $table->enum('type', ['individual', 'company'])->default('company');
            $table->foreignId('billing_currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->foreignId('price_list_id')->nullable()->constrained('item_price_lists')->nullOnDelete();
            $table->foreignId('default_company_bank_account_id')->nullable()
                ->constrained('bank_accounts')->nullOnDelete();
            $table->boolean('is_transporter')->default(false);
            $table->boolean('is_internal_supplier')->default(false);
            $table->text('supplier_detail')->nullable();
            $table->string('website');
            $table->timestamps();
        });

        Schema::create('supplierables', function (Blueprint $table) {
            $table->foreignId('supplier_id');
            $table->morphs('supplierable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('supplier_groups');
        Schema::dropIfExists('supplierables');
        Schema::dropIfExists('bank_accounts');
    }
};
