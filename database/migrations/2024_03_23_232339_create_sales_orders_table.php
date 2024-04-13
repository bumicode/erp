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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('series')->unique();
            $table->enum('status', [
                'draft',
                'on hold',
                'to deliver and bill',
                'to bill',
                'to deliver',
                'completed',
                'cancelled',
                'closed',
            ])->default('draft');
            $table->enum('delivery_status', [
                'not delivered',
                'partially delivered',
                'fully delivered',
                'closed',
                'not applicable',
            ])->default('not delivered');
            $table->enum('billed_status', [
                'not billed',
                'partially billed',
                'fully billed',
                'closed',
            ])->default('not billed');
            $table->timestamp('posting_date');
            $table->timestamp('delivery_date')->nullable();
            $table->enum('order_type', ['sales', 'maintenance', 'shopping chart']);
            $table->json('items');
            $table->integer('total_qty');
            $table->float('total_net_weight');
            $table->float('total_amount');
            $table->json('sales_taxes_and_charges');
            $table->float('total_tax_charge');
            $table->float('grand_total');
            $table->float('rounding_adjustment');
            $table->float('rounded_total');
            $table->float('advance_paid');
            $table->foreignId('sales_tax_charge_template')->nullable()->constrained('tax_charge_templates')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('customer_billing_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('customer_shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('customer_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('payment_terms_template_id')->nullable()->constrained('payment_terms_templates')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
