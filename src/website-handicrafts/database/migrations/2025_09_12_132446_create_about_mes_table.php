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
        Schema::create('about_mes', function (Blueprint $table) {
            $table->id();
            $table->string('about_author_image'); // path to image - untranslated
            $table->timestamps();
        });

        Schema::create('about_me_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_me_id')
                ->constrained('about_mes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('about_author_image_alt', 150)->nullable();
            $table->text('content')->nullable();
            $table->boolean('main_page')->default(false);

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->index(['locale', 'main_page'], 'locale_main_page_index');
            $table->index('main_page');
        });

        Schema::addTranslatableChecks('about_me_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_me_translations');
        Schema::dropIfExists('about_mes');
    }
};
