<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // path to image - untranslated
            $table->string('slug', 100)->unique()->comment('Unique identifier used in URLs');
            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name', 100)->index('category_translations_name_index');
            $table->string('image_alt', 150)->nullable();
            $table->string('label_meta', 100)->nullable()->comment('Optional meta label');

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->unique(['category_id', 'locale'], 'category_locale_unique');
        });

        Schema::addTranslatableChecks('category_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
};
