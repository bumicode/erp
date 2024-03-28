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
        Schema::create('payment_terms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_group')->default(false);
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('customer_groups')->nullOnDelete();
            $table->foreignId('default_price_list_id')->nullable()->constrained('price_lists')->nullOnDelete();
            $table->foreignId('default_payment_terms_template_id')
                ->nullable()->constrained('payment_terms_templates')
                ->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_groups');
        Schema::dropIfExists('payment_terms_templates');
    }
};
