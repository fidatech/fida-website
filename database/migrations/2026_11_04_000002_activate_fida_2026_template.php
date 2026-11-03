<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Launch the Fida 2026 design on the public website.
 *
 * Only the template choice changes; every other saved appearance setting is kept.
 * Administrators can switch back at any time under Website settings → Appearance,
 * and rolling back this migration restores the previous template.
 */
return new class extends Migration
{
    private const KEY = 'website.appearance';

    public function up(): void
    {
        if (! config('website.appearance.activate_modern_on_migrate', true) || ! Schema::hasTable('site_settings')) {
            return;
        }

        $row = DB::table('site_settings')->where('key', self::KEY)->first();
        $value = $row && is_string($row->value) ? (json_decode($row->value, true) ?: []) : [];

        $value['previous_template'] = $value['template'] ?? 'technology';
        $value['template'] = 'modern';

        DB::table('site_settings')->updateOrInsert(
            ['key' => self::KEY],
            [
                'group' => 'appearance',
                'value' => json_encode($value),
                'type' => 'json',
                'is_public' => true,
                'updated_at' => now(),
                'created_at' => $row->created_at ?? now(),
            ],
        );
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $row = DB::table('site_settings')->where('key', self::KEY)->first();

        if (! $row || ! is_string($row->value)) {
            return;
        }

        $value = json_decode($row->value, true) ?: [];
        $value['template'] = $value['previous_template'] ?? 'technology';
        unset($value['previous_template']);

        DB::table('site_settings')->where('key', self::KEY)->update([
            'value' => json_encode($value),
            'updated_at' => now(),
        ]);
    }
};
