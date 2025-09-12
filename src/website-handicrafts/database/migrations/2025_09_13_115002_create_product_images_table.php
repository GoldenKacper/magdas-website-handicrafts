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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // path to image - untranslated
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('product_image_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_image_id')
                ->constrained('product_images')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('image_alt', 150)->nullable();

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->unique(['product_image_id', 'locale'], 'product_image_locale_unique');
        });

        Schema::addTranslatableChecks('product_image_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_image_translations');
        Schema::dropIfExists('product_images');
    }
};
