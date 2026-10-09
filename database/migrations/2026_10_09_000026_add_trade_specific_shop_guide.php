<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const MARKER = '<section data-sector-search-guide="v1">';

    public function up(): void
    {
        $page = ContentPage::query()->where('slug', 'wholesale-retail-software-afghanistan')->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;
        $sections = [
            'en' => <<<'HTML'
<section data-sector-search-guide="v1">
<h2>Shop software for specific trades in Afghanistan</h2>
<p>A shop database is more useful when it reflects how that business sells, buys, measures and follows up. The examples below are possible system scopes to discuss with a business owner, not a catalogue of separate Fida products already available.</p>
<h3>Fabric, clothing, shoes and tailoring</h3>
<p>A fabric shop system or fabric shop database may record fabric by roll, length, color and purchase lot. Women's and men's clothing shops may instead need size, style, color and seasonal stock variants. A shoe shop may track size and pair variants. Tailoring software adds customer measurements, order dates, fitting, alterations, advances and delivery. Confirm whether “رخت فروشی” means fabric, ready-made clothing, or both for each buyer.</p>
<h3>Phones, computers, printers and accessories</h3>
<p>A mobile phone shop system can track model, color, IMEI or serial number where appropriate, warranty and trade-ins. Computer, computer-accessory and printer shops may need component compatibility, serial numbers, consumables, repair intake and supplier warranty claims. Those repair flows should be scoped separately from a simple sales counter.</p>
<h3>Vehicles, spare parts and batteries</h3>
<p>A vehicle sales system can record vehicle identity, condition, documents, reservation, customer payments and handover. A spare-parts shop needs part number, compatible models, supplier, substitute part and stock location. Battery shops may need capacity, type, serial number, warranty and exchange or return records. Here “بطری فروشی” refers to electrical batteries, including solar or vehicle batteries where relevant.</p>
<h3>Fuel, paint and solar equipment</h3>
<p>A fuel station or fuel trading system may need tank or depot records, purchases, volume, dispensing or deliveries, shift reconciliation and credit accounts. An engine-oil shop has a different product and stock workflow; confirm which meaning of “تیل” a buyer intends. Paint shops may track brand, shade, pack size and mixing orders. Solar equipment sellers may track panel, inverter and battery specifications, bundle quotations, installation jobs and warranties.</p>
<h3>Jewelry and gold shops</h3>
<p>A gold or jewelry shop system may record item weight, purity, making charges, purchase and sale documents, customer balances and stock adjustments. Pricing formulas, assay procedures and any legal or tax obligations must be set by the business and qualified advisers before implementation.</p>
<p>Search wording in Dari includes سیستم رخت فروشی، دیتابیس رخت فروشی، سیستم رخت فروشی زنانه، سیستم رخت فروشی مردانه، سیستم موبایل فروشی، سیستم خیاطی، سیستم ماشین فروشی، سیستم پرزه فروشی، سیستم تیل، سیستم رنگ فروشی، سیستم کمپیوتر فروشی، سیستم لوازم کمپیوتر، سیستم پرنتر فروشی، سیستم بطری فروشی، سیستم سولر فروشی، سیستم طلا فروشی and سیستم بوت فروشی. Each trade needs a scoped workflow and evidence from a real buyer before it is treated as a finished product.</p>
</section>
HTML,
            'fa' => <<<'HTML'
<section data-sector-search-guide="v1">
<h2>سیستم و دیتابیس دوکان برای صنف‌های مختلف در افغانستان</h2>
<p>سیستم فروش و دیتابیس زمانی مفید است که روش خرید، فروش، اندازه‌گیری و پیگیری همان صنف را پوشش دهد. موارد زیر برای تعیین نیاز با صاحب کسب‌وکار است؛ هر مورد به معنای محصول جداگانه و آماده فروش فیدا نیست.</p>
<h3>رخت‌فروشی زنانه و مردانه، بوت‌فروشی و خیاطی</h3>
<p>سیستم رخت فروشی و دیتابیس رخت فروشی می‌تواند رخت را به اساس طاقه، متر، رنگ و خرید ثبت کند. سیستم رخت فروشی زنانه و سیستم رخت فروشی مردانه برای لباس آماده به سایز، مدل، رنگ و موجودی فصلی نیاز متفاوتی دارند. سیستم بوت فروشی سایز و جوره را پیگیری می‌کند. سیستم خیاطی اندازه مشتری، فرمایش دوخت، تاریخ پرو، اصلاحات، پیش‌پرداخت و تحویل را ثبت می‌کند. نخست روشن شود که «رخت» نزد مشتری به پارچه، لباس آماده یا هر دو اشاره دارد.</p>
<h3>موبایل، کمپیوتر، پرنتر و لوازم جانبی</h3>
<p>سیستم موبایل فروشی می‌تواند مدل، رنگ، IMEI یا نمبر سریال در صورت نیاز، ضمانت و تبدیل دستگاه را پیگیری کند. سیستم کمپیوتر فروشی، سیستم لوازم کمپیوتر و سیستم پرنتر فروشی ممکن است به سازگاری قطعات، نمبر سریال، مواد مصرفی، ثبت دستگاه برای ترمیم و پیگیری ضمانت عرضه‌کننده نیاز داشته باشند. بخش ترمیم باید جدا از فروش ساده تعریف شود.</p>
<h3>ماشین، پرزه و بطری</h3>
<p>سیستم ماشین فروشی معلومات موتر، وضعیت، اسناد، ریزرف، پرداخت مشتری و تحویل را ثبت می‌کند. سیستم پرزه فروشی نمبر پرزه، موترهای سازگار، پرزه بدیل، عرضه‌کننده و موقعیت گدام را در نظر می‌گیرد. سیستم بطری فروشی ظرفیت، نوع، نمبر سریال، ضمانت و تبدیل یا برگشت بطری را پیگیری می‌کند؛ در اینجا «بطری» به بطری برق یا موتر اشاره دارد.</p>
<h3>تیل، رنگ و سولر</h3>
<p>سیستم تیل برای پمپ یا تجارت مواد سوختی ممکن است تانک، خرید، حجم، فروش یا توزیع، حساب شیفت و قرض مشتری را ثبت کند. دوکان روغنیات موتر روند متفاوت دارد؛ نوع تیل باید با مشتری مشخص شود. سیستم رنگ فروشی برند، کد رنگ، اندازه بسته و سفارش ترکیب رنگ را پیگیری می‌کند. سیستم سولر فروشی مشخصات پنل، انورتر و بطری، قیمت بسته، نصب و ضمانت را در بر می‌گیرد.</p>
<h3>طلا و زیورات</h3>
<p>سیستم طلا فروشی می‌تواند وزن، عیار، اجرت ساخت، اسناد خرید و فروش، حساب مشتری و اصلاح موجودی را ثبت کند. شیوه قیمت‌گذاری، بررسی عیار و الزامات قانونی یا مالیاتی را خود کسب‌وکار و مشاوران مسئول باید تعیین کنند.</p>
<p>این‌ها نمونه نیازهای صنفی اند. پیش از ساخت هر سیستم، نمونه رسید، ثبت موجودی، گزارش و روند واقعی همان دوکان بررسی شود. «دیتابیس» به تنهایی معادل سیستم کامل فروش، حسابداری، ترمیم یا نصب نیست.</p>
</section>
HTML,
            'ps' => <<<'HTML'
<section data-sector-search-guide="v1">
<h2>په افغانستان کې د بېلابېلو دوکانونو لپاره سیستم او ډیټابیس</h2>
<p>د دوکان سیستم هغه وخت ګټور دی چې د هماغې سوداګرۍ پېرود، پلور، اندازه او تعقیب وښيي. لاندې برخې له سوداګر سره د اړتیا د معلومولو لپاره دي؛ دا نه ښيي چې د فیدا هره برخه لا دمخه جلا تیار محصول دی.</p>
<h3>د ټوکر او جامو دوکان، بوټان او خیاطي</h3>
<p>د رخت پلور سیستم او د رخت پلور ډیټابیس ټوکر د طاقې، متر، رنګ او پېرود له مخې ثبتولی شي. د ښځو او نارینه وو د جامو دوکانونه بیا د سایز، ډول، رنګ او موسمي موجودۍ بېلابېلې اړتیاوې لري. د بوټانو پلور سیستم سایز او جوړې تعقیبوي. د خیاطۍ سیستم د مشتری اندازې، د ګنډلو فرمایش، پرو، اصلاح، مخکې پیسې او سپارنه ثبتوي. له مشتری سره باید روښانه شي چې «رخت» ټوکر، تیارې جامې او که دواړه دي.</p>
<h3>موبایل، کمپیوټر، پرنټر او پرزې</h3>
<p>د موبایل پلور سیستم د مودل، رنګ، د اړتیا پر مهال IMEI یا سریال نمبر، ضمانت او بدلون ریکارډ ساتلی شي. د کمپیوټر پلور سیستم، د کمپیوټر لوازمو سیستم او د پرنټر پلور سیستم کېدای شي د پرزو سازګاري، سریال نمبر، مصرفي توکي، د ترمیم ثبت او د عرضه کوونکي ضمانت وغواړي. د ترمیم بهیر باید د عادي پلور څخه جلا وټاکل شي.</p>
<h3>موټرونه، اضافي پرزې او بېټرۍ</h3>
<p>د موټر پلور سیستم د موټر پېژندنه، حالت، اسناد، ریزرف، تادیې او سپارنه ثبتوي. د موټر پرزو پلور سیستم د پرزې نمبر، سازګار موټر، بدیله پرزه، عرضه کوونکی او د ګدام ځای ساتي. د بېټرۍ پلور سیستم ظرفیت، ډول، سریال نمبر، ضمانت او بېرته اخیستل تعقیبوي؛ دلته «بطری» برېښنايي یا د موټر بېټرۍ ته اشاره کوي.</p>
<h3>تیل، رنګ او سولر</h3>
<p>د تېلو پمپ یا سوداګرۍ سیستم کېدای شي ټانکونه، پېرود، حجم، خرڅلاو، د شیفټ حساب او د مشتری پور ثبت کړي. د موټر د غوړو دوکان بېل بهیر لري؛ د «تیل» مطلب باید له مشتری وپوښتل شي. د رنګ پلور سیستم برانډ، د رنګ کوډ، د بسته اندازه او د ګډولو فرمایش ساتي. د سولر پلور سیستم د پینل، انورټر او بېټرۍ مشخصات، د ټولګې نرخ، نصب او ضمانت تعقیبوي.</p>
<h3>د سرو زرو او ګاڼو دوکان</h3>
<p>د طلا پلور سیستم د توکي وزن، عیار، د جوړولو اجرت، د پېر او پلور سندونه، د مشتری حساب او د موجودۍ سمون ثبتولی شي. د نرخ فورمول، د عیار ارزونه او قانوني یا مالیاتي مکلفیتونه باید سوداګر او مسلکي سلاکاران وټاکي.</p>
<p>دا د صنفونو د اړتیاوو بېلګې دي. د هر سیستم تر جوړولو مخکې د اصلي دوکان رسیدونه، د موجودۍ ریکارډونه، راپورونه او کاري بهیر وڅېړئ. ډیټابیس په خپله د پلور، حسابدارۍ، ترمیم او نصب بشپړ سیستم نه دی.</p>
</section>
HTML,
        ];

        foreach ($sections as $locale => $section) {
            $current = (string) ($body[$locale] ?? '');

            if (! str_contains($current, self::MARKER)) {
                $body[$locale] = rtrim($current)."\n\n".$section;
            }
        }

        $page->body = $body;
        $page->sitemap_last_modified_at = now();
        $page->save();
    }

    public function down(): void
    {
        $page = ContentPage::query()->where('slug', 'wholesale-retail-software-afghanistan')->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;

        foreach ($body as $locale => $html) {
            $html = (string) $html;
            $start = strpos($html, self::MARKER);

            if ($start === false) {
                continue;
            }

            $end = strpos($html, '</section>', $start);

            if ($end !== false) {
                $body[$locale] = rtrim(substr($html, 0, $start)).substr($html, $end + strlen('</section>'));
            }
        }

        $page->body = $body;
        $page->sitemap_last_modified_at = now();
        $page->save();
    }
};
