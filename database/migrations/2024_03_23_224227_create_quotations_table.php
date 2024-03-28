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
        Schema::create('tax_charge_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->enum('status', ['Draft', 'Open', 'Replied', 'Partially Ordered', 'Lost', 'Cancelled', 'Expired'])
                ->default('Draft');
            $table->timestamp('posting_date');
            $table->timestamp('valid_upto');
            $table->enum('order_type', ['Sales', 'Maintenance', 'Shopping Chart']);
            $table->integer('total_qty');
            $table->integer('total_net_weight');
            $table->bigInteger('total_amount');
            $table->foreignId('tax_category_id')->constrained('tax_categories')->nullOnDelete();
            $table->bigInteger('sales_tax_charge_template')->nullable();
            $table->foreign('sales_tax_charge_template')->references('id')->on('tax_charge_templates');
            $table->bigInteger('total_tax_charge');
            $table->bigInteger('grand_total');
            $table->bigInteger('rounding_adjustment')->nullable();
            $table->bigInteger('rounded_total')->nullable();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();
            $table->foreignId('warehouse_accepted_id')->constrained('warehouses')->nullOnDelete();
            $table->foreignId('warehouse_rejected_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->integer('accepted_qty');
            $table->integer('rejected_qty')->default(0);
            $table->double('item_rate');
            $table->double('total_amount');
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('quotation_tax_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
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

        Schema::create('quotationables', function (Blueprint $table) {
            $table->foreignId('quotation_id');
            $table->morphs('quotationable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotation_tax_charges');
        Schema::dropIfExists('account_id');
        Schema::dropIfExists('quotationables');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('tax_charge_templates');
        Schema::dropIfExists('items');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('accounts');
    }
};
