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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete()
                ->noActionOnUpdate()
                ->comment('Null means do not disclose');

            $table->decimal('default_price', 8, 2)->nullable()->comment('Null means do not disclose');
            $table->char('default_currency', 3)->nullable();
            $table->smallInteger('stock_quantity')->default(1)->nullable()->comment('Available stock quantity. Null means do not disclose');

            $table->string('slug', 100)->unique()->comment('Unique identifier used in URLs');

            $table->timestamps();
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('availability_id')
                ->nullable()
                ->constrained('availabilities')
                ->nullOnDelete()
                ->noActionOnUpdate()
                ->comment('Null means do not disclose');

            $table->string('short_name', 30);
            $table->string('name', 100);
            $table->text('description')->nullable();

            $table->decimal('price', 8, 2)->nullable()->comment('if specified, it will replace the default price from the products table');
            $table->char('currency', 3)->nullable()->comment('if specified, it will replace the default currency from the products table');

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->unique(['product_id', 'locale']);
        });
        Schema::addTranslatableChecks('product_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
};
