<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MigrationMacrosServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /**
         *  Columns + indexes (be careful with the name "order")
         */
        Blueprint::macro('withTranslatableDefaults', function () {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $table = $this;

            $table->unsignedSmallInteger('order')
                ->default(99)
                ->comment('Order for display, lower numbers first');

            $table->boolean('visible')
                ->default(false)
                ->comment('Whether to show this publicly');

            $table->char('locale', 5)
                ->default('pl')
                ->comment('IETF locale code, e.g. pl, en, en-GB');

            $table->timestamps();

            // Indexes
            $this->index('order');
            $this->index('visible');
            $this->index('locale');
        });

        /**
         *  CHECK constraints via ALTER TABLE (after create)
         * Note: MySQL 8.0.16+ actually enforces CHECK.
         * The table must have ‘locale’ and ‘order’ columns.
         */
        Schema::macro('addTranslatableChecks', function (string $table) {
            // locale: 2–5 chars
            DB::statement("
                ALTER TABLE `{$table}`
                ADD CONSTRAINT `chk_{$table}_locale_length`
                CHECK (CHAR_LENGTH(`locale`) BETWEEN 2 AND 5)
            ");

            // order: 0–100
            DB::statement("
                ALTER TABLE `{$table}`
                ADD CONSTRAINT `chk_{$table}_order`
                CHECK (`order` BETWEEN 0 AND 100)
            ");
        });

        /**
         *  Macro for dropping constraints in down()
         */
        Schema::macro('dropTranslatableChecks', function (string $table) {
            // Names must match those above!
            DB::statement("ALTER TABLE `{$table}` DROP CONSTRAINT `chk_{$table}_locale_length`");
            DB::statement("ALTER TABLE `{$table}` DROP CONSTRAINT `chk_{$table}_order`");
        });
    }
}
