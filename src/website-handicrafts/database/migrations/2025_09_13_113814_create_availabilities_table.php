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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();

            $table->string('code', 32)->unique()->comment('Machine code: in_stock, out_of_stock, preorder, discontinued');
            $table->string('label', 100)->comment('Human label, e.g. Dostępny');
            $table->boolean('is_active')->default(true);

            $table->char('locale', 5)->default('pl')->comment('IETF locale code, e.g.: pl, en, en-GB');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `availabilities` ADD CONSTRAINT `chk_availabilities_locale_length` CHECK (CHAR_LENGTH(`locale`) BETWEEN 2 AND 5)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
