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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('series')->unique();
            $table->enum('status', ['draft', 'open', 'replied', 'partially ordered', 'lost', 'cancelled', 'expired'])
                ->default('Draft');
            $table->timestamp('posting_date');
            $table->timestamp('valid_upto');
            $table->enum('order_type', ['Sales', 'Maintenance', 'Shopping Chart']);
            $table->integer('total_qty');
            $table->integer('total_net_weight');
            $table->bigInteger('total_amount');
            $table->bigInteger('sales_tax_charge_template')->nullable();
            $table->foreign('sales_tax_charge_template')->references('id')->on('tax_charge_templates');
            $table->bigInteger('total_tax_charge');
            $table->bigInteger('grand_total');
            $table->bigInteger('rounding_adjustment')->nullable();
            $table->bigInteger('rounded_total')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->integer('accepted_qty');
            $table->integer('rejected_qty')->default(0);
            $table->float('item_rate');
            $table->float('total_amount');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_tax_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->enum('tax_type', [
                'actual',
                'on net total',
                'on previous row amount',
                'on previous row total',
                'on item quantity',
            ]);
            $table->foreignId('account_id')->constrained('accounts')->nullOnDelete();
            $table->float('tax_rate');
            $table->float('tax_amount');
            $table->float('tax_total');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('accounts');
    }
};
