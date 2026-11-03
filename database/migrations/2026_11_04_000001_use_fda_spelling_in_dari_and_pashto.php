<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fida's Dari and Pashto name is written فدا, not فیدا.
 *
 * Updates published website content already in the database, including text stored as
 * escaped JSON. Leads, clients, contracts and analytics data are left as they were recorded.
 */
return new class extends Migration
{
    private const TABLES = ['content_pages', 'article_categories', 'article_authors', 'portfolio_projects', 'site_settings'];

    private const TEXT_TYPES = ['char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext', 'json', 'clob'];

    public function up(): void
    {
        $replacements = [];
        foreach (['فیدا', 'فيدا'] as $old) {
            $new = 'فدا';
            $replacements[$old] = $new;

            // Text saved through json_encode is stored as \uXXXX escapes (lower- or upper-case hex).
            $escapedOld = trim(json_encode($old), '"');
            $escapedNew = trim(json_encode($new), '"');
            $replacements[$escapedOld] = $escapedNew;
            $replacements[preg_replace_callback('/\\\\u([0-9a-f]{4})/', fn ($m) => '\\u'.strtoupper($m[1]), $escapedOld)] = preg_replace_callback('/\\\\u([0-9a-f]{4})/', fn ($m) => '\\u'.strtoupper($m[1]), $escapedNew);
        }

        foreach (self::TABLES as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'id')) {
                continue;
            }

            $columns = collect(Schema::getColumns($table))
                ->filter(fn (array $column) => in_array(strtolower((string) ($column['type_name'] ?? '')), self::TEXT_TYPES, true))
                ->pluck('name')
                ->reject(fn (string $name) => in_array($name, ['slug', 'key', 'group', 'type', 'status'], true))
                ->values()
                ->all();

            if ($columns === []) {
                continue;
            }

            DB::table($table)->select(array_merge(['id'], $columns))->orderBy('id')->chunkById(100, function ($rows) use ($table, $columns, $replacements): void {
                foreach ($rows as $row) {
                    $changes = [];

                    foreach ($columns as $column) {
                        $value = $row->{$column};

                        if (! is_string($value) || $value === '') {
                            continue;
                        }

                        $updated = strtr($value, $replacements);

                        if ($updated !== $value) {
                            $changes[$column] = $updated;
                        }
                    }

                    if ($changes !== []) {
                        DB::table($table)->where('id', $row->id)->update($changes);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        // Spelling correction only; restoring the old spelling is intentionally not automated.
    }
};
