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
        Schema::create('uoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
            $table->boolean('status')->default(true);
            $table->boolean('must_be_whole_number')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('item_groups')->nullOnDelete();
            $table->boolean('is_group')->default(true);
            $table->boolean('show_in_website')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['enabled', 'disabled', 'template', 'variant'])->default('enabled');
            $table->boolean('active')->default(true);
            $table->boolean('allow_alternative_item')->default(false);
            $table->boolean('maintain_stock')->default(true);
            $table->boolean('is_fixed_asset')->default(false);
            $table->boolean('has_variant')->default(false);
            $table->enum('variant_base_on', ['item attribute', 'manufacturer'])->default('item attribute');
            $table->boolean('allow_purchase')->default(true);
            $table->integer('over_delivery_allowance')->default(0);
            $table->integer('over_billing_allowance')->default(0);
            $table->integer('opening_stock')->default(0);
            $table->float('standard_selling_rate')->default(0);
            $table->float('standard_buying_rate')->default(0);
            $table->foreignId('item_group_id')->nullable()->constrained('item_groups')->nullOnDelete();
            $table->foreignId('default_uom_id')->nullable()->constrained('uoms')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('item_has_barcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->string('barcode');
            $table->enum('barcode_type', ['EAN-13', 'EAN-8', 'UPC-A', 'UPC-E', 'JAN', 'ISBN', 'ISSN'])->default('EAN-13');
            $table->foreignId('uom_id')->constrained('uoms')->cascadeOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_has_uoms', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_default')->default(false);
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('uom_id')->constrained('uoms')->cascadeOnDelete();
            $table->float('conversion_rate')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_stock_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('uom_id')->constrained('uoms')->cascadeOnDelete();
            $table->bigInteger('stock');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();
        });

        Schema::table('sales_invoice_items', function (Blueprint $table) {
            $table->foreignId('item_id')->nullable()->constrained('items')->nullOnDelete();
        });

        Schema::create('item_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_has_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('item_attribute_id')->constrained('item_attributes')->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_attribute_id')->constrained('item_attributes')->cascadeOnDelete();
            $table->string('name');
            $table->string('abbreviation');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->foreignId('uom_id')->constrained('uoms')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->boolean('use_batch_wise_valuation')->default(false);
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->date('expiry_date')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('uom_id')->nullable()->constrained('uoms')->cascadeOnDelete();
            $table->integer('packing_unit')->default(1);
            $table->foreignId('price_list_id')->constrained('item_price_lists')->cascadeOnDelete();
            $table->boolean('is_buying')->default(false);
            $table->boolean('is_selling')->default(false);
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->float('rate');
            $table->date('valid_from')->default(Now());
            $table->date('valid_upto')->nullable();
            $table->integer('lead_time_in_days')->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_tax_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->date('valid_from')->nullable();
            $table->decimal('minimum_net_rate')->nullable();
            $table->decimal('maximum_net_rate')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('item_purchasing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('default_uom')->nullable()->constrained('uoms')->nullOnDelete();
            $table->integer('lead_time_in_days')->nullable();
            $table->integer('safety_stock')->nullable();
            $table->integer('minimum_order_quantity')->default(0);
            $table->foreignId('country_of_origin')->nullable()->constrained('countries')->nullOnDelete();
            $table->boolean('enable_deffered_expense')->default(false);
            $table->bigInteger('deffered_expense_account')->nullable();
            $table->integer('no_of_months')->nullable();
            $table->boolean('is_delivered_by_supplier')->default(false);
            $table->timestamps();
        });

        Schema::create('item_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->integer('shelf_life')->nullable();
            $table->integer('warranty_period')->nullable();
            $table->date('end_of_life')->nullable()->default('2099-12-31');
            $table->decimal('weight_per_unit')->nullable();
            $table->enum('default_material_request_type', [
                'purchase',
                'material_transfer',
                'material_issue',
                'manufacture',
                'customer_provided',
                'other',
            ])
                ->nullable()
                ->default('purchase');
            $table->boolean('allow_negative_stock')->nullable()->default(false);
            $table->enum('valuation_method', ['fifo', 'moving average', 'lifo'])->nullable();
            $table->foreignId('weight_uom_id')->nullable()->constrained('uoms')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('conversions', function (Blueprint $table) {
            $table->foreignId('uom_id');
            $table->morphs('convertible');
            $table->float('conversion_factor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
        Schema::dropIfExists('item_purchasing');
        Schema::dropIfExists('item_inventories');
        Schema::dropIfExists('item_taxes');
        Schema::dropIfExists('item_tax_templates');
        Schema::dropIfExists('item_prices');
        Schema::dropIfExists('item_has_attributes');

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });
        Schema::table('sales_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });
        Schema::table('sales_invoice_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        });

        Schema::dropIfExists('item_attribute_values');
        Schema::dropIfExists('item_has_barcode');
        Schema::dropIfExists('item_has_uoms');
        Schema::dropIfExists('item_attributes');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('items');
        Schema::dropIfExists('uoms');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('item_groups');
    }
};
