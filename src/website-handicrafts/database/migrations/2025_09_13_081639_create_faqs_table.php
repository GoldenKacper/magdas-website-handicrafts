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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable()->comment('Name to the icon from font awesome - untranslated');

            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id')
                ->constrained('faqs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('question')->nullable();
            $table->text('answer')->nullable();

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->unique(['faq_id', 'locale'], 'faq_locale_unique');
        });

        Schema::addTranslatableChecks('faq_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
};
