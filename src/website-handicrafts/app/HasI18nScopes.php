<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

/**
 * Common I18n scopes for models with a translations() relation
 *
 * Requirements in the model:
 *  - relation: translations(): HasMany
 *  - the translations table must contain the following columns:
 *      - locale (string)
 *      - sorting column (e.g. 'order')
 *      - visibility column (e.g. 'visible')
 */
trait HasI18nScopes
{
    /**
     * Sort by a column in translations with a fallback to $fallbackLocale.
     *
     * @param Builder $query
     * @param string $orderColumn     Column name in translations table (e.g. 'order')
     * @param string $direction       'asc' | 'desc'
     * @param string|null $fallbackLocale e.g. 'pl' (null => no fallback)
     * @return Builder
     */
    public function scopeOrderByI18n(Builder $query, string $orderColumn = 'order', string $direction = 'asc', ?string $fallbackLocale = 'pl')
    {
        $locale     = app()->getLocale();
        $baseTable  = $this->getTable();
        $basePk     = $this->getKeyName();

        // Get parameters from the translations() relation
        $trRel      = $this->translations();
        $trTable    = $trRel->getRelated()->getTable();   // e.g. category_translations
        $fkColumn   = $trRel->getForeignKeyName();        // e.g. category_id

        // Quote columns depending on the database driver
        $driver = $query->getConnection()->getDriverName();
        $qi     = $driver === 'pgsql' ? '"' : '`';
        $colQ   = $qi . $orderColumn . $qi;

        // Safe, portable subquery with COALESCE (first current locale, then fallback)
        $coalesce = "(SELECT {$colQ} FROM {$trTable} t1
                      WHERE t1.{$fkColumn} = {$baseTable}.{$basePk} AND t1.locale = ?
                      LIMIT 1)";

        if ($fallbackLocale !== null) {
            $coalesce = "COALESCE(
                {$coalesce},
                (SELECT {$colQ} FROM {$trTable} t2
                 WHERE t2.{$fkColumn} = {$baseTable}.{$basePk} AND t2.locale = '{$fallbackLocale}'
                 LIMIT 1),
                99
            )";
        } else {
            $coalesce = "COALESCE({$coalesce}, 99)";
        }

        return $query->orderByRaw(
            $coalesce . ' ' . (strtolower($direction) === 'desc' ? 'DESC' : 'ASC'),
            [$locale]
        );
    }

    /**
     * Filter only “visible” entries by column in translations with a fallback to $fallbackLocale.
     *
     * @param Builder $query
     * @param string $visibleColumn   Column name in translations indicating visibility (e.g. 'visible')
     * @param string|null $fallbackLocale e.g. 'pl' (null => no fallback)
     * @return Builder
     */
    public function scopeWhereVisibleI18n(Builder $query, string $visibleColumn = 'visible', ?string $fallbackLocale = 'pl')
    {
        $locale   = app()->getLocale();

        $trRel    = $this->translations();
        $trTable  = $trRel->getRelated()->getTable(); // e.g. category_translations
        $fkColumn = $trRel->getForeignKeyName();      // e.g. category_id
        $basePk   = $this->getKeyName();
        $baseTbl  = $this->getTable();

        // Condition: visible in current locale ...
        // or – if not visible in current – visible in fallback
        return $query->where(function ($q) use ($locale, $fallbackLocale, $trTable, $fkColumn, $visibleColumn, $basePk, $baseTbl) {
            // visible in current locale
            $q->whereExists(function ($sub) use ($locale, $trTable, $fkColumn, $visibleColumn, $basePk, $baseTbl) {
                $sub->from($trTable)
                    ->whereColumn($trTable . '.' . $fkColumn, $baseTbl . '.' . $basePk)
                    ->where($trTable . '.locale', $locale)
                    ->where($trTable . '.' . $visibleColumn, true);
            });

            if ($fallbackLocale !== null) {
                // ... or not visible in current but visible in fallback
                $q->orWhere(function ($q2) use ($locale, $fallbackLocale, $trTable, $fkColumn, $visibleColumn, $basePk, $baseTbl) {
                    $q2->whereNotExists(function ($sub) use ($locale, $trTable, $fkColumn, $visibleColumn, $basePk, $baseTbl) {
                        $sub->from($trTable)
                            ->whereColumn($trTable . '.' . $fkColumn, $baseTbl . '.' . $basePk)
                            ->where($trTable . '.locale', $locale)
                            ->where($trTable . '.' . $visibleColumn, true);
                    })
                        ->whereExists(function ($sub) use ($fallbackLocale, $trTable, $fkColumn, $visibleColumn, $basePk, $baseTbl) {
                            $sub->from($trTable)
                                ->whereColumn($trTable . '.' . $fkColumn, $baseTbl . '.' . $basePk)
                                ->where($trTable . '.locale', $fallbackLocale)
                                ->where($trTable . '.' . $visibleColumn, true);
                        });
                });
            }
        });
    }
}
