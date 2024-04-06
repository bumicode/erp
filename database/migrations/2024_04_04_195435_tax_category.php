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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
        Schema::table('item_taxes', function (Blueprint $table) {
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::table('item_taxes', function (Blueprint $table) {
            $table->dropForeign(['tax_category_id']);
            $table->dropColumn('tax_category_id');
        });
        Schema::dropIfExists('tax_categories');
    }
};
