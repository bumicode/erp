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
            $table->boolean('status')->default(true);
            $table->boolean('must_be_whole_number')->default(false);
            $table->timestamps();
        });

        Schema::create('item_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('item_groups')->nullOnDelete();
            $table->boolean('is_group')->default(true);
            $table->boolean('show_in_website')->default(false);
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->boolean('status')->default(true);
            $table->foreignId('parent_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->boolean('allow_alternative_item')->default(false);
            $table->boolean('maintain_stock')->default(true);
            $table->boolean('is_fixed_asset')->default(false);
            $table->foreignId('item_group_id')->nullable()->constrained('item_groups')->nullOnDelete();
            $table->boolean('has_variant')->default(false);
            $table->foreignId('default_uom_id')->nullable()->constrained('uoms')->nullOnDelete();
            $table->string('code');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('variant_base_on', ['item attribute', 'manufacturer'])->default('item attribute');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->boolean('allow_purchase')->default(true);
            $table->integer('over_delivery_allowance')->default(0);
            $table->integer('over_billing_allowance')->default(0);
        });

        Schema::create('item_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('item_has_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('item_attribute_id')->constrained('item_attributes')->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('item_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_attribute_id')->constrained('item_attributes')->cascadeOnDelete();
            $table->string('name');
            $table->string('abbreviation');
            $table->timestamps();
        });

        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->boolean('status')->default(true);
            $table->boolean('use_batch_wise_valuation')->default(false);
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->date('expiry_date')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('uom_id')->nullable()->constrained('uoms')->cascadeOnDelete();
            $table->integer('packing_unit')->default(1);
            $table->foreignId('price_list_id')->constrained('price_lists')->cascadeOnDelete();
            $table->boolean('is_buying')->default(false);
            $table->boolean('is_selling')->default(false);
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->decimal('rate')->default(0, 000);
            $table->date('valid_from')->default(Now());
            $table->date('valid_upto')->nullable();
            $table->integer('lead_time_in_days')->default(0);
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('item_tax_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('item_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('tax_category_id')->nullable()->constrained('tax_categories')->nullOnDelete();
            $table->date('valid_from')->nullable();
            $table->decimal('minimum_nat_rate')->nullable();
            $table->decimal('maximum_nat_rate')->nullable();
            $table->timestamps();
        });

        Schema::create('item_inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('shelf_life')->default(0);
            $table->integer('warranty_period')->nullable();
            $table->date('end_of_life')->default('2099-12-31');
            $table->decimal('weight_per_unit')->default(0, 000);
            $table->enum('default_material_request_type', [
                'purchase',
                'material_transfer',
                'material_issue',
                'manufacture',
                'customer_provided',
                'other',
            ])->default('purchase');
            $table->boolean('allow_negative_stock')->default(false);
            $table->enum('valuation_method', ['FIFO', 'Moving Average', 'LIFO'])->default('in_stock');
            $table->foreignId('weight_uom_id')->nullable()->constrained('uoms')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_taxes');
        Schema::dropIfExists('item_tax_templates');
        Schema::dropIfExists('item_prices');
        Schema::dropIfExists('item_has_attributes');

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('allow_alternative_item');
            $table->dropColumn('maintain_stock');
            $table->dropColumn('has_variant');
            $table->dropColumn('code');
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('is_fixed_asset');
            $table->dropColumn('variant_base_on');
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropForeign(['item_group_id']);
            $table->dropColumn('item_group_id');
            $table->dropForeign(['default_uom_id']);
            $table->dropColumn('default_uom_id');
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
            $table->dropColumn('allow_purchase');
            $table->dropColumn('over_delivery_allowance');
            $table->dropColumn('over_billing_allowance');
        });

        Schema::dropIfExists('item_attribute_values');
        Schema::dropIfExists('item_attributes');
        Schema::dropIfExists('item_groups');
        Schema::dropIfExists('batches');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('item_inventories');
        Schema::dropIfExists('uoms');
    }
};
