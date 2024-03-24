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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained('sales_orders');
            $table->string('series')->unique();
            $table->timestamps();
        });

        Schema::create('sales_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained('sales_invoices')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->nullOnDelete();
            $table->foreignId('warehouse_accepted_id')->constrained('warehouses')->nullOnDelete();
            $table->foreignId('warehouse_rejected_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->integer('accepted_qty');
            $table->integer('rejected_qty')->default(0);
            $table->double('item_rate');
            $table->double('total_amount');
            $table->timestamps();
        });

        Schema::create('sales_invoice_tax_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained('sales_invoices')->cascadeOnDelete();
            $table->enum('tax_type', [
                'Actual',
                'On Net Total',
                'On Previous Row Amount',
                'On Previous Row Total',
                'On Item Quantity',
            ]);
            $table->foreignId('account_id')->constrained('accounts')->nullOnDelete();
            $table->double('tax_rate');
            $table->double('tax_amount');
            $table->double('tax_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
        Schema::dropIfExists('sales_invoice_items');
        Schema::dropIfExists('sales_invoice_tax_charges');
    }
};
