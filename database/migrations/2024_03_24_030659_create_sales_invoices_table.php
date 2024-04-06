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
            $table->enum('status', [
                'Draft',
                'On Hold',
                'To Deliver and Bill',
                'To Bill',
                'To Deliver',
                'Completed',
                'Cancelled',
                'Closed',
            ])->default('Draft');
            $table->enum('delivery_status', [
                'Not Delivered',
                'Partially Delivered',
                'Fully Delivered',
                'Closed',
                'Not Applicable',
            ])->default('Not Delivered');
            $table->enum('billed_status', [
                'Not Billed',
                'Partially Billed',
                'Fully Billed',
                'Closed',
            ])->default('Not Billed');
            $table->timestamp('posting_date');
            $table->timestamp('delivery_date')->nullable();
            $table->enum('order_type', ['Sales', 'Maintenance', 'Shopping Chart']);
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->bigInteger('customer_address_id')->unsigned();
            $table->foreign('customer_address_id')->references('id')->on('addresses');
            $table->bigInteger('customer_contact_id')->unsigned();
            $table->foreign('customer_contact_id')->references('id')->on('contacts');
            $table->bigInteger('customer_shipping_address_id')->unsigned()->nullable();
            $table->foreign('customer_shipping_address_id')->references('id')->on('addresses');
            $table->double('total_qty');
            $table->integer('total_net_weight');
            $table->double('total_amount');
            $table->bigInteger('sales_tax_charge_template')->nullable();
            $table->foreign('sales_tax_charge_template')->references('id')->on('tax_charge_templates');
            $table->double('total_tax_charge');
            $table->double('grand_total');
            $table->double('rounding_adjustment')->nullable();
            $table->double('rounded_total')->nullable();
            $table->bigInteger('payment_terms_template_id')->unsigned();
            $table->foreign('payment_terms_template_id')->references('id')->on('payment_terms_templates');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_items');
        Schema::dropIfExists('sales_invoice_tax_charges');
        Schema::dropIfExists('sales_invoices');
    }
};
