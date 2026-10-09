<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $updates = [
        'company-facts' => [
            'old' => ['en' => 'Fida Technologies Afghanistan', 'fa' => 'Fida Technologies افغانستان', 'ps' => 'Fida Technologies افغانستان'],
            'new' => ['en' => 'Fida Technologies company facts', 'fa' => 'مشخصات رسمی Fida Technologies', 'ps' => 'د Fida Technologies رسمي معلومات'],
        ],
        'accounting-software-afghanistan-buyers-guide' => [
            'old' => ['en' => 'accounting software Afghanistan', 'fa' => 'نرم افزار حسابداری افغانستان', 'ps' => 'حسابدارۍ سافټویر افغانستان'],
            'new' => ['en' => 'how to choose accounting software Afghanistan', 'fa' => 'راهنمای انتخاب نرم افزار حسابداری افغانستان', 'ps' => 'په افغانستان کې د حسابدارۍ سافټویر د انتخاب لارښود'],
        ],
        'ngo-erp-finance-software-afghanistan-guide' => [
            'old' => ['en' => 'NGO software Afghanistan', 'fa' => 'سیستم NGO افغانستان', 'ps' => 'د NGO سافټویر افغانستان'],
            'new' => ['en' => 'NGO ERP and finance software selection Afghanistan', 'fa' => 'راهنمای انتخاب ERP و سیستم مالی NGO افغانستان', 'ps' => 'په افغانستان کې د NGO ERP او مالي سافټویر د انتخاب لارښود'],
        ],
        'agriculture-software-afghanistan-guide' => [
            'old' => ['en' => 'agriculture software Afghanistan', 'fa' => 'نرم افزار زراعت افغانستان', 'ps' => 'د کرنې سافټویر افغانستان'],
            'new' => ['en' => 'how to choose agribusiness software Afghanistan', 'fa' => 'راهنمای انتخاب نرم افزار زراعت افغانستان', 'ps' => 'په افغانستان کې د کرنې سافټویر د انتخاب لارښود'],
        ],
        'asset-management-software-afghanistan-guide' => [
            'old' => ['en' => 'asset management software Afghanistan', 'fa' => 'نرم افزار مدیریت دارایی افغانستان', 'ps' => 'د شتمنیو مدیریت سافټویر افغانستان'],
            'new' => ['en' => 'asset lifecycle management software guide Afghanistan', 'fa' => 'راهنمای سیستم چرخه عمر دارایی افغانستان', 'ps' => 'په افغانستان کې د شتمنۍ د ژوند دورې سیسټم لارښود'],
        ],
    ];

    public function up(): void
    {
        $this->apply('old', 'new');
    }

    public function down(): void
    {
        $this->apply('new', 'old');
    }

    private function apply(string $from, string $to): void
    {
        foreach ($this->updates as $slug => $change) {
            $record = DB::table('content_pages')->where('slug', $slug)->first(['id', 'primary_query']);

            if (! $record) {
                continue;
            }

            $queries = json_decode((string) $record->primary_query, true);

            if (! is_array($queries)) {
                continue;
            }

            $changed = false;

            foreach ($change[$from] as $locale => $expected) {
                if (($queries[$locale] ?? null) !== $expected) {
                    continue;
                }

                $queries[$locale] = $change[$to][$locale];
                $changed = true;
            }

            if ($changed) {
                DB::table('content_pages')->where('id', $record->id)->update([
                    'primary_query' => json_encode($queries, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
