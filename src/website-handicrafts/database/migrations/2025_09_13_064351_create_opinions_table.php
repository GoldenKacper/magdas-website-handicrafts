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
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // path to image - untranslated
            $table->string('slug', 100)->unique()->comment('Unique identifier used in URLs');
            $table->timestamps();
        });

        Schema::create('opinion_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opinion_id')
                ->constrained('opinions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('first_name', 50);
            $table->char('country_code', 5)->nullable()->comment('IETF locale code where the user is from, e.g.: pl, en, en-GB');
            $table->text('content');
            $table->string('image_alt', 150)->nullable();
            $table->string('label_meta', 100)->nullable()->comment('Optional meta label');
            $table->unsignedTinyInteger('rating')->nullable()->comment('Rating from 1 to 5. Null if not given');

            // Added columns (order, visible, locale) + indexes + timestamps
            $table->withTranslatableDefaults();

            $table->unique(['opinion_id', 'locale']);
        });

        // CHECK for 2–5 chars for country_code
        DB::statement("ALTER TABLE `opinion_translations` ADD CONSTRAINT chk_opinion_translations_country_code_length CHECK (char_length(`country_code`) BETWEEN 2 AND 5)");
        Schema::addTranslatableChecks('opinion_translations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opinion_translations');
        Schema::dropIfExists('opinions');
    }
};
