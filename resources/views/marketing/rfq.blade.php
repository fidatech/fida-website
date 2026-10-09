@extends('layouts.marketing')

@section('content')
@php
    $copy = match (app()->getLocale()) {
        'fa' => [
            'eyebrow' => 'RFQ / RFP / TENDER',
            'title' => 'نیازمندی تخنیکی و تجارتی خود را ارسال کنید.',
            'intro' => 'برای پروژه‌های دولت، NGO، INGO، بانک، مخابرات و سازمان‌ها. سند RFQ، RFP، BOQ یا tender را ضمیمه کنید و محدوده مورد نیاز را مشخص سازید.',
            'org' => 'نام سازمان', 'org_type' => 'نوع سازمان', 'contact' => 'شخص تماس', 'job' => 'وظیفه / عنوان',
            'email' => 'ایمیل رسمی', 'phone' => 'شماره تماس', 'country' => 'کشور', 'city' => 'شهر',
            'method' => 'نوع درخواست', 'ref' => 'شماره / مرجع تدارکات', 'deadline' => 'آخرین مهلت ارسال',
            'capabilities' => 'حوزه‌های مورد نیاز', 'budget' => 'بودجه (اختیاری)', 'delivery' => 'محل تحویل / تطبیق',
            'summary' => 'خلاصه پروژه', 'scope' => 'محدوده و مشخصات تخنیکی', 'compliance' => 'شرایط compliance / warranty / training',
            'timeline' => 'زمان‌بندی مورد انتظار', 'document' => 'سند RFQ / RFP / BOQ', 'privacy' => 'تأیید می‌کنم که اجازه ارسال این معلومات و سند را دارم.',
            'submit' => 'ارسال RFQ به Fida Technologies', 'note' => 'اطلاع این درخواست مستقیماً به info@fida.af ارسال می‌شود.',
        ],
        'ps' => [
            'eyebrow' => 'RFQ / RFP / TENDER',
            'title' => 'خپله تخنیکي او سوداګریزه اړتیا وسپارئ.',
            'intro' => 'د دولت، NGO، INGO، بانک، مخابرات او سازماني پروژو لپاره. RFQ، RFP، BOQ یا tender سند ضمیمه او اړین scope مشخص کړئ.',
            'org' => 'د ادارې نوم', 'org_type' => 'د ادارې ډول', 'contact' => 'د اړیکې شخص', 'job' => 'دنده / عنوان',
            'email' => 'رسمي برېښنالیک', 'phone' => 'ټیلیفون', 'country' => 'هېواد', 'city' => 'ښار',
            'method' => 'د غوښتنې ډول', 'ref' => 'تدارکاتي مرجع', 'deadline' => 'د سپارلو وروستۍ نېټه',
            'capabilities' => 'اړینې وړتیاوې', 'budget' => 'بودجه (اختیاري)', 'delivery' => 'د سپارنې / پلي کولو ځای',
            'summary' => 'د پروژې لنډیز', 'scope' => 'تخنیکي scope او مشخصات', 'compliance' => 'compliance / warranty / training شرایط',
            'timeline' => 'اټکلی مهالویش', 'document' => 'RFQ / RFP / BOQ سند', 'privacy' => 'تاییدوم چې د دې معلوماتو او سند د استولو اجازه لرم.',
            'submit' => 'RFQ Fida Technologies ته وسپارئ', 'note' => 'د دې غوښتنې خبرتیا مستقیم info@fida.af ته استول کېږي.',
        ],
        default => [
            'eyebrow' => 'RFQ / RFP / TENDER',
            'title' => 'Send your technical and commercial requirement.',
            'intro' => 'For government, NGO, INGO, banking, telecom and enterprise procurement. Attach an RFQ, RFP, BOQ or tender document and give us the scope needed for a responsible response.',
            'org' => 'Organization name', 'org_type' => 'Organization type', 'contact' => 'Contact person', 'job' => 'Job title',
            'email' => 'Official email', 'phone' => 'Phone / WhatsApp', 'country' => 'Country', 'city' => 'City',
            'method' => 'Procurement method', 'ref' => 'Procurement reference', 'deadline' => 'Submission deadline',
            'capabilities' => 'Required capabilities', 'budget' => 'Budget (optional)', 'delivery' => 'Delivery / implementation location',
            'summary' => 'Project summary', 'scope' => 'Scope and technical requirements', 'compliance' => 'Compliance / warranty / training requirements',
            'timeline' => 'Expected timeline', 'document' => 'RFQ / RFP / BOQ document', 'privacy' => 'I confirm I am authorized to submit this information and document.',
            'submit' => 'Submit RFQ to Fida Technologies', 'note' => 'This request is recorded securely and an alert is sent directly to info@fida.af.',
        ],
    };
    $orgTypes = [
        'government' => 'Government / Public Institution', 'ngo' => 'NGO', 'ingo' => 'INGO',
        'un' => 'UN / International Organization', 'donor' => 'Donor / Development Programme',
        'bank' => 'Bank / Financial Institution', 'telecom' => 'Telecom', 'private' => 'Private Enterprise', 'other' => 'Other',
    ];
@endphp

<section class="page-hero rfq-hero">
    <div class="container page-hero-layout">
        <div class="page-hero-copy reveal">
            <div class="micro-label"><span>RFQ</span>{{ $copy['eyebrow'] }}</div>
            <h1>{{ $copy['title'] }}</h1>
            <p>{{ $copy['intro'] }}</p>
            <div class="rfq-trust-row">
                <span>SOFTWARE + INFRASTRUCTURE</span><span>BOQ / RFP / TENDER</span><span>AFGHANISTAN DELIVERY</span>
            </div>
        </div>
    </div>
</section>

<section class="section rfq-section" id="rfq-form">
    <div class="container rfq-shell">
        <aside class="rfq-side reveal">
            <div class="micro-label"><span>01</span>PROCUREMENT INTAKE</div>
            <h2>{{ $page->translation('title') }}</h2>
            <div class="prose">{!! $page->translation('body') !!}</div>
            <div class="rfq-contact-note"><strong>DIRECT PROCUREMENT EMAIL</strong><a href="mailto:info@fida.af">info@fida.af</a><span>{{ config('website.phone') }}</span></div>
        </aside>

        <form class="lead-form rfq-form reveal" action="{{ route('rfq.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            <div class="form-console"><span class="live-dot"></span><b>FORMAL RFQ CHANNEL</b><small>INFO@FIDA.AF</small></div>
            @if(session('rfq_success'))<div class="form-success" role="status" data-conversion="generate_lead">{{ session('rfq_success') }}</div>@endif
            @if($errors->any())<div class="form-errors" role="alert"><strong>Please review the highlighted fields.</strong></div>@endif

            <div class="form-grid">
                <label><span>{{ $copy['org'] }}</span><input name="organization_name" value="{{ old('organization_name') }}" required></label>
                <label><span>{{ $copy['org_type'] }}</span><select name="organization_type" required><option value="">—</option>@foreach($orgTypes as $value => $label)<option value="{{ $value }}" @selected(old('organization_type')===$value)>{{ $label }}</option>@endforeach</select></label>
                <label><span>{{ $copy['contact'] }}</span><input name="contact_name" value="{{ old('contact_name') }}" required autocomplete="name"></label>
                <label><span>{{ $copy['job'] }}</span><input name="job_title" value="{{ old('job_title') }}"></label>
                <label><span>{{ $copy['email'] }}</span><input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
                <label><span>{{ $copy['phone'] }}</span><input name="phone" value="{{ old('phone') }}" dir="ltr" autocomplete="tel"></label>
                <label><span>{{ $copy['country'] }}</span><input name="country" value="{{ old('country','Afghanistan') }}"></label>
                <label><span>{{ $copy['city'] }}</span><input name="city" value="{{ old('city') }}"></label>
                <label><span>{{ $copy['method'] }}</span><select name="procurement_method" required>@foreach(['rfq'=>'RFQ','rfp'=>'RFP','tender'=>'Tender','eoi'=>'EOI','direct'=>'Direct procurement'] as $value=>$label)<option value="{{ $value }}" @selected(old('procurement_method','rfq')===$value)>{{ $label }}</option>@endforeach</select></label>
                <label><span>{{ $copy['ref'] }}</span><input name="procurement_reference" value="{{ old('procurement_reference') }}"></label>
                <label><span>{{ $copy['deadline'] }}</span><input type="date" name="submission_deadline" value="{{ old('submission_deadline') }}"></label>
                <label><span>{{ $copy['delivery'] }}</span><input name="delivery_location" value="{{ old('delivery_location') }}"></label>

                <fieldset class="form-wide rfq-capability-fieldset">
                    <legend>{{ $copy['capabilities'] }}</legend>
                    <div class="rfq-capability-grid">
                        @foreach($capabilities as $capability)
                            <label>
                                <input type="checkbox" name="capabilities[]" value="{{ $capability['key'] }}" @checked(in_array($capability['key'], old('capabilities', []), true))>
                                <span><strong>{{ __("website.solutions.{$capability['key']}.title") }}</strong><small>{{ __("website.solutions.{$capability['key']}.description") }}</small></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <label><span>{{ $copy['budget'] }} · Currency</span><select name="budget_currency"><option value="">—</option>@foreach(['USD','AFN','EUR'] as $currency)<option value="{{ $currency }}" @selected(old('budget_currency')===$currency)>{{ $currency }}</option>@endforeach</select></label>
                <label><span>{{ $copy['budget'] }} · Min</span><input type="number" min="0" step="0.01" name="budget_min" value="{{ old('budget_min') }}"></label>
                <label><span>{{ $copy['budget'] }} · Max</span><input type="number" min="0" step="0.01" name="budget_max" value="{{ old('budget_max') }}"></label>
                <label><span>{{ $copy['timeline'] }}</span><input name="timeline" value="{{ old('timeline') }}" placeholder="e.g. 60 days"></label>
                <label class="form-wide"><span>{{ $copy['summary'] }}</span><textarea name="project_summary" rows="4" required>{{ old('project_summary') }}</textarea></label>
                <label class="form-wide"><span>{{ $copy['scope'] }}</span><textarea name="scope_requirements" rows="7" required>{{ old('scope_requirements') }}</textarea></label>
                <label class="form-wide"><span>{{ $copy['compliance'] }}</span><textarea name="compliance_requirements" rows="4">{{ old('compliance_requirements') }}</textarea></label>
                <label class="form-wide rfq-file-field"><span>{{ $copy['document'] }} <b>PDF · DOCX · XLSX · ZIP · MAX 15 MB</b></span><input type="file" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"></label>
                <label class="form-wide rfq-consent"><input type="checkbox" name="privacy_accepted" value="1" required @checked(old('privacy_accepted'))><span>{{ $copy['privacy'] }}</span></label>
            </div>
            <p class="rfq-form-note">{{ $copy['note'] }}</p>
            <button class="button button-lime form-submit" type="submit">{{ $copy['submit'] }}<span class="button-arrow">↗</span></button>
        </form>
    </div>
</section>

@if($faqs !== [])
<section class="page-faq-section">
    <div class="container page-section-grid">
        <div class="page-section-intro reveal"><div class="micro-label"><span>02</span>RFQ FAQ</div><h2>Procurement questions</h2></div>
        <div class="faq-list reveal">@foreach($faqs as $faq)<details class="faq-item" @if($loop->first) open @endif><summary><span>{{ str_pad((string)$loop->iteration,2,'0',STR_PAD_LEFT) }}</span>{{ $faq['question'] }}<i>+</i></summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div>
    </div>
</section>
@endif
@endsection
