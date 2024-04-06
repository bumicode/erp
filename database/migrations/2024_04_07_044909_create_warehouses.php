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
        Schema::create('warehouse_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_group')->default(false);
            $table->string('name');
            $table->foreignId('warehouse_type_id')->nullable()->constrained('warehouse_types');
            $table->foreignId('parent_id')->nullable()->constrained('warehouses');
            $table->foreignId('in_transit_warehouse_id')->nullable()->constrained('warehouses');
            $table->foreignId('account_id')->nullable()->constrained('accounts');
            $table->foreignId('address_id')->nullable()->constrained('addresses');
            $table->foreignId('contact_id')->nullable()->constrained('contacts');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->foreignId('warehouse_accepted_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->foreignId('warehouse_rejected_id')->nullable()->constrained('warehouses')->nullOnDelete();
        });
        Schema::table('sales_items', function (Blueprint $table) {
            $table->foreignId('warehouse_accepted_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->foreignId('warehouse_rejected_id')->nullable()->constrained('warehouses')->nullOnDelete();
        });
        Schema::table('sales_invoice_items', function (Blueprint $table) {
            $table->foreignId('warehouse_accepted_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->foreignId('warehouse_rejected_id')->nullable()->constrained('warehouses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropForeign(['warehouse_accepted_id']);
            $table->dropColumn('warehouse_accepted_id');
            $table->dropForeign(['warehouse_rejected_id']);
            $table->dropColumn('warehouse_rejected_id');
        });
        Schema::table('sales_items', function (Blueprint $table) {
            $table->dropForeign(['warehouse_accepted_id']);
            $table->dropColumn('warehouse_accepted_id');
            $table->dropForeign(['warehouse_rejected_id']);
            $table->dropColumn('warehouse_rejected_id');
        });
        Schema::table('sales_invoice_items', function (Blueprint $table) {
            $table->dropForeign(['warehouse_accepted_id']);
            $table->dropColumn('warehouse_accepted_id');
            $table->dropForeign(['warehouse_rejected_id']);
            $table->dropColumn('warehouse_rejected_id');
        });
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('warehouse_types');
    }
};
