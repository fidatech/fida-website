<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const MARKER = '<section data-retail-search-language="v1">';

    private const FAQ_KEY = 'shop-retail-search-language-v1';

    public function up(): void
    {
        $page = ContentPage::query()
            ->where('slug', 'wholesale-retail-software-afghanistan')
            ->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;
        $sections = [
            'en' => <<<'HTML'
<section data-retail-search-language="v1">
<h2>Shop management, retail and warehouse system search terms</h2>
<p>People looking for software for a shop or store may use phrases such as shop management system, shop software, retail store system, shop database, inventory or stock software, warehouse management system, supermarket software, or POS system in Afghanistan. Dari searches may use «سیستم دوکان»، «سیستم دکانداری»، «سیستم فروشگاه»، «سیستم پرچون‌فروشی»، «سیستم عمده‌فروشی»، «سیستم گدامداری»، «دیتابیس دوکان»، «دیتابیس دکانداری» and «دیتابیس پرچون‌فروشی». Pashto searches may use «د دوکان سیستم»، «د دوکاندارۍ سیستم»، «د پرچون پلور سیستم»، «د عمده پلور سیستم»، «د ګدامدارۍ سیستم» and «د دوکان ډیټابیس».</p>
<h3>What these search terms can refer to</h3>
<ul>
<li><strong>Shop or shopkeeper system:</strong> sales, purchases, cashier shifts, customer balances and daily reports.</li>
<li><strong>Shop database:</strong> organized, searchable product, barcode, unit, supplier, customer, price and transaction records.</li>
<li><strong>Warehouse or stock system:</strong> receiving, storage locations, transfers, counts, damaged stock and traceable adjustments.</li>
<li><strong>Wholesale and retail software:</strong> connected stock with distinct price lists, customer terms, order handling, delivery and point-of-sale workflows.</li>
</ul>
<p>These phrases describe related needs, but they do not all mean the same system. A small shop, supermarket, wholesaler and multi-warehouse distributor should confirm their users, devices, stock rules, customer credit and reports before choosing a scope. This industry page covers connected wholesale, distribution and retail workflows; it does not claim that every configuration is already a separate ready-to-buy Fida product.</p>
</section>
HTML,
            'fa' => <<<'HTML'
<section data-retail-search-language="v1">
<h2>عبارت‌های جستجو برای سیستم دوکان، پرچون‌فروشی و گدامداری</h2>
<p>افرادی که برای دوکان یا فروشگاه به نرم‌افزار نیاز دارند ممکن است عبارت‌هایی مانند سیستم دوکان، سیستم دکانداری، سیستم فروشگاه، سیستم پرچون‌فروشی، سیستم عمده‌فروشی، سیستم گدامداری، دیتابیس دوکان، دیتابیس دکانداری، دیتابیس پرچون‌فروشی، نرم‌افزار موجودی کالا، مدیریت گدام، نرم‌افزار سوپرمارکیت یا POS را جستجو کنند. در انگلیسی نیز عبارت‌هایی مانند shop management system، retail shop software، shop database، inventory software و warehouse management system استفاده می‌شود.</p>
<h3>این عبارت‌ها معمولاً به چه نیازهایی اشاره دارند؟</h3>
<ul>
<li><strong>سیستم دوکان یا دکانداری:</strong> ثبت فروش و خرید، شیفت صندوق، حساب مشتریان و گزارش روزانه.</li>
<li><strong>دیتابیس دوکان:</strong> ثبت منظم و قابل جستجوی کالا، بارکد، واحد، عرضه‌کننده، مشتری، قیمت و معاملات.</li>
<li><strong>سیستم گدامداری یا مدیریت موجودی:</strong> دریافت کالا، محل نگهداری، انتقال، شمارش، کالای آسیب‌دیده و اصلاح قابل پیگیری.</li>
<li><strong>سیستم عمده‌فروشی و پرچون‌فروشی:</strong> موجودی مشترک با قیمت‌های جدا، شرایط مشتری، سفارش، تحویل و صندوق فروش.</li>
</ul>
<p>این عبارت‌ها نیازهای مرتبط را توصیف می‌کنند، اما همیشه به یک نوع سیستم اشاره ندارند. دوکان کوچک، سوپرمارکیت، عمده‌فروش و توزیع‌کننده چندانباری باید پیش از تعیین محدوده، کاربران، دستگاه‌ها، قواعد موجودی، قرض مشتری و گزارش‌های لازم را بررسی کنند. این صفحه روندهای یکپارچه عمده‌فروشی، توزیع و پرچون را توضیح می‌دهد و ادعا نمی‌کند که هر پیکربندی یک محصول جداگانه و آماده خرید فیدا است.</p>
</section>
HTML,
            'ps' => <<<'HTML'
<section data-retail-search-language="v1">
<h2>د دوکان، پرچون او ګدامدارۍ د سیستم د لټون کلیمې</h2>
<p>هغه کسان چې د دوکان یا پلورنځي لپاره سافټویر لټوي، کېدای شي داسې عبارتونه وکاروي: د دوکان سیستم، د دوکاندارۍ سیستم، د پرچون پلور سیستم، د عمده پلور سیستم، د ګدامدارۍ سیستم، د دوکان ډیټابیس، د پرچون پلور ډیټابیس، د موجودۍ سافټویر، د سوپرمارکېټ سافټویر یا POS سیستم. په انګلیسي کې shop management system، retail shop software، shop database، inventory software او warehouse management system هم لټول کېږي.</p>
<h3>دا کلیمې معمولاً کومو اړتیاوو ته اشاره کوي؟</h3>
<ul>
<li><strong>د دوکان یا دوکاندارۍ سیستم:</strong> پلور او پېرود، د صندوق شېفټونه، د مشتریانو حسابونه او ورځني راپورونه.</li>
<li><strong>د دوکان ډیټابیس:</strong> د product، barcode، unit، supplier، customer، price او معاملاتو منظم او د لټون وړ ریکارډونه.</li>
<li><strong>د ګدامدارۍ یا موجودۍ سیستم:</strong> ترلاسه کول، د ساتنې ځایونه، لېږد، شمېرنه، خراب stock او د تعقیب وړ سمونونه.</li>
<li><strong>د عمده او پرچون پلور سافټویر:</strong> ګډ stock، خو جلا نرخونه، د مشتری شرطونه، فرمایشونه، تحویل او POS کاري بهیرونه.</li>
</ul>
<p>دا عبارتونه سره تړلې اړتیاوې بیانوي، خو هر یو د یوه شان سیستم معنا نه لري. کوچنی دوکان، سوپرمارکېټ، عمده‌پلورونکی او څو ګدامه لرونکی وېش‌کوونکی باید د سیستم د ساحې تر ټاکلو مخکې کاروونکي، وسایل، د stock اصول، د مشتریانو پورونه او اړین راپورونه روښانه کړي. دا صنعتي پاڼه د عمده پلور، وېش او پرچون تړلي کاري بهیرونه تشریح کوي؛ دا ادعا نه کوي چې هره بڼه یې د فیدا جلا او د پېرلو لپاره چمتو محصول دی.</p>
</section>
HTML,
        ];

        foreach ($sections as $locale => $section) {
            $current = (string) ($body[$locale] ?? '');

            if (! str_contains($current, self::MARKER)) {
                $body[$locale] = rtrim($current)."\n\n".$section;
            }
        }

        $metadata = (array) $page->metadata;
        $extraTopics = [
            'en' => [
                'shop management system Afghanistan',
                'shop software Afghanistan',
                'retail shop software Afghanistan',
                'shop database software',
                'warehouse management software Afghanistan',
                'supermarket POS Afghanistan',
            ],
            'fa' => [
                'سیستم دوکان افغانستان',
                'سیستم دکانداری افغانستان',
                'سیستم پرچون فروشی افغانستان',
                'دیتابیس دوکان',
                'سیستم گدامداری افغانستان',
                'نرم افزار سوپرمارکت افغانستان',
            ],
            'ps' => [
                'د دوکان سیستم افغانستان',
                'د دوکاندارۍ سیستم افغانستان',
                'د پرچون پلور سیستم افغانستان',
                'د دوکان ډیټابیس',
                'د ګدامدارۍ سیستم افغانستان',
                'د سوپرمارکېټ سافټویر افغانستان',
            ],
        ];
        $topics = (array) ($metadata['secondary_topics'] ?? []);

        foreach ($extraTopics as $locale => $items) {
            $topics[$locale] = array_values(array_unique([
                ...(array) ($topics[$locale] ?? []),
                ...$items,
            ]));
        }

        $metadata['secondary_topics'] = $topics;
        $faqs = (array) ($metadata['faqs'] ?? []);
        $hasFaq = collect($faqs)->contains(
            fn (mixed $faq): bool => is_array($faq) && ($faq['key'] ?? null) === self::FAQ_KEY
        );

        if (! $hasFaq) {
            $faqs[] = [
                'key' => self::FAQ_KEY,
                'question' => [
                    'en' => 'What does a shop management system or shop database include?',
                    'fa' => 'سیستم دوکان یا دیتابیس فروشگاه معمولاً چه مواردی را شامل می‌شود؟',
                    'ps' => 'د دوکان د مدیریت سیستم یا ډیټابیس کومې برخې لري؟',
                ],
                'answer' => [
                    'en' => 'It commonly refers to connected product records, sales, purchases, stock, customer and supplier balances, and reports. A warehouse, supermarket POS, wholesale order flow or multi-branch setup may need additional scope.',
                    'fa' => 'معمولاً به ثبت کالا، فروش، خرید، موجودی، حساب مشتری و عرضه‌کننده و گزارش‌ها اشاره دارد. گدام، POS سوپرمارکیت، سفارش عمده یا چند شعبه ممکن است محدوده جداگانه بخواهد.',
                    'ps' => 'دا عموماً د محصولاتو ریکارډ، پلور، پېرود، موجودي، د مشتریانو او عرضه کوونکو حسابونه او راپورونه رانغاړي. ګدام، سوپرمارکېټ POS، د عمده فرمایش یا څو څانګو لپاره جلا محدوده پکار کېدای شي.',
                ],
            ];
            $metadata['faqs'] = $faqs;
        }

        $page->body = $body;
        $page->metadata = $metadata;
        $page->sitemap_last_modified_at = now();
        $page->save();
    }

    public function down(): void
    {
        $page = ContentPage::query()
            ->where('slug', 'wholesale-retail-software-afghanistan')
            ->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;

        foreach ($body as $locale => $html) {
            $html = (string) $html;
            $position = strpos($html, self::MARKER);

            if ($position !== false) {
                $body[$locale] = rtrim(substr($html, 0, $position));
            }
        }

        $metadata = (array) $page->metadata;
        $faqs = collect((array) ($metadata['faqs'] ?? []))
            ->reject(fn (mixed $faq): bool => is_array($faq) && ($faq['key'] ?? null) === self::FAQ_KEY)
            ->values()
            ->all();
        $metadata['faqs'] = $faqs;

        $remove = [
            'en' => [
                'shop management system Afghanistan',
                'shop software Afghanistan',
                'retail shop software Afghanistan',
                'shop database software',
                'warehouse management software Afghanistan',
                'supermarket POS Afghanistan',
            ],
            'fa' => [
                'سیستم دوکان افغانستان',
                'سیستم دکانداری افغانستان',
                'سیستم پرچون فروشی افغانستان',
                'دیتابیس دوکان',
                'سیستم گدامداری افغانستان',
                'نرم افزار سوپرمارکت افغانستان',
            ],
            'ps' => [
                'د دوکان سیستم افغانستان',
                'د دوکاندارۍ سیستم افغانستان',
                'د پرچون پلور سیستم افغانستان',
                'د دوکان ډیټابیس',
                'د ګدامدارۍ سیستم افغانستان',
                'د سوپرمارکېټ سافټویر افغانستان',
            ],
        ];
        $topics = (array) ($metadata['secondary_topics'] ?? []);

        foreach ($remove as $locale => $items) {
            $topics[$locale] = array_values(array_diff(
                (array) ($topics[$locale] ?? []),
                $items
            ));
        }

        $metadata['secondary_topics'] = $topics;
        $page->body = $body;
        $page->metadata = $metadata;
        $page->save();
    }
};
