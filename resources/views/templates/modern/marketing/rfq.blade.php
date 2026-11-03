@extends('layouts.marketing')

@section('content')
@php
    $copy = match (app()->getLocale()) {
        'fa' => [
            'eyebrow' => 'RFQ / RFP / TENDER',
            'title' => 'نیازمندی تخنیکی و تجارتی خود را ارسال کنید.',
            'intro' => 'برای پروژه‌های دولت، NGO، INGO، بانک، مخابرات و سازمان‌ها. سند RFQ، RFP، BOQ یا داوطلبی را ضمیمه کنید و محدوده مورد نیاز را مشخص سازید.',
            'org' => 'نام سازمان', 'org_type' => 'نوع سازمان', 'contact' => 'شخص تماس', 'job' => 'وظیفه / عنوان',
            'email' => 'ایمیل رسمی', 'phone' => 'شماره تماس', 'country' => 'کشور', 'city' => 'شهر',
            'method' => 'نوع درخواست', 'ref' => 'شماره / مرجع تدارکات', 'deadline' => 'آخرین مهلت ارسال',
            'capabilities' => 'حوزه‌های مورد نیاز', 'budget' => 'بودجه (اختیاری)', 'delivery' => 'محل تحویل / تطبیق',
            'summary' => 'خلاصه پروژه', 'scope' => 'محدوده و مشخصات تخنیکی', 'compliance' => 'شرایط مطابقت، تضمین و آموزش',
            'timeline' => 'زمان‌بندی مورد انتظار', 'document' => 'سند RFQ / RFP / BOQ', 'privacy' => 'تأیید می‌کنم که اجازه ارسال این معلومات و سند را دارم.',
            'submit' => 'ارسال RFQ به فدا تکنالوژی', 'note' => 'اطلاع این درخواست مستقیماً به ایمیل رسمی تدارکات فدا ارسال می‌شود.',
        ],
        'ps' => [
            'eyebrow' => 'RFQ / RFP / TENDER',
            'title' => 'خپله تخنیکي او سوداګریزه اړتیا وسپارئ.',
            'intro' => 'د دولت، NGO، INGO، بانک، مخابرات او سازماني پروژو لپاره. RFQ، RFP، BOQ یا د داوطلبۍ سند ضمیمه او اړین حدود مشخص کړئ.',
            'org' => 'د ادارې نوم', 'org_type' => 'د ادارې ډول', 'contact' => 'د اړیکې شخص', 'job' => 'دنده / عنوان',
            'email' => 'رسمي برېښنالیک', 'phone' => 'ټیلیفون', 'country' => 'هېواد', 'city' => 'ښار',
            'method' => 'د غوښتنې ډول', 'ref' => 'تدارکاتي مرجع', 'deadline' => 'د سپارلو وروستۍ نېټه',
            'capabilities' => 'اړینې وړتیاوې', 'budget' => 'بودجه (اختیاري)', 'delivery' => 'د سپارنې / پلي کولو ځای',
            'summary' => 'د پروژې لنډیز', 'scope' => 'تخنیکي حدود او مشخصات', 'compliance' => 'د مطابقت، تضمین او روزنې شرطونه',
            'timeline' => 'اټکلی مهالویش', 'document' => 'RFQ / RFP / BOQ سند', 'privacy' => 'تاییدوم چې د دې معلوماتو او سند د استولو اجازه لرم.',
            'submit' => 'RFQ فدا ټکنالوژي ته وسپارئ', 'note' => 'د دې غوښتنې خبرتیا مستقیم د فدا رسمي تدارکاتي برېښنالیک ته استول کېږي.',
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
            'submit' => 'Submit RFQ to Fida Technologies', 'note' => 'This request is recorded securely and an alert is sent directly to Fida Technologies procurement.',
        ],
    };
    $orgTypes = [
        'government' => 'Government / Public Institution', 'ngo' => 'NGO', 'ingo' => 'INGO',
        'un' => 'UN / International Organization', 'donor' => 'Donor / Development Programme',
        'bank' => 'Bank / Financial Institution', 'telecom' => 'Telecom', 'private' => 'Private Enterprise', 'other' => 'Other',
    ];
@endphp

@include('marketing.partials.mx-page-hero', [
    'crumbs' => [[$page->translation('title'), null]],
    'title' => $copy['title'],
    'summary' => $copy['intro'],
])

<section class="mx-section mx-section-tight" id="rfq-form">
    <div class="mx-wrap mx-rfq">
        <aside class="mx-rfq-side">
            <h2>{{ $page->translation('title') }}</h2>
            <div class="mx-prose">{!! $page->translation('body') !!}</div>
            <dl class="mx-contact-direct">
                <div><dt>{{ $copy['email'] }}</dt><dd><a href="mailto:{{ config('website.procurement_email') }}">{{ config('website.procurement_email') }}</a></dd></div>
                <div><dt>{{ $copy['phone'] }}</dt><dd><a href="tel:{{ config('website.phone') }}" dir="ltr">{{ config('website.phone') }}</a></dd></div>
            </dl>
        </aside>

        <form class="mx-form" action="{{ route('rfq.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
            <input type="hidden" name="source_url" value="{{ url()->current() }}">
            <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <div class="honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            @if(session('rfq_success'))<div class="mx-form-success" role="status" data-conversion="generate_lead">{{ session('rfq_success') }}</div>@endif
            @if($errors->any())<div class="mx-form-errors" role="alert">{{ __('website.contact.review') }}</div>@endif

            <div class="mx-form-grid">
                <label><span>{{ $copy['org'] }}</span><input name="organization_name" value="{{ old('organization_name') }}" required></label>
                <label><span>{{ $copy['org_type'] }}</span><select name="organization_type" required><option value="">—</option>@foreach(__('modern.rfq.org_types') as $value => $label)<option value="{{ $value }}" @selected(old('organization_type')===$value)>{{ $label }}</option>@endforeach</select></label>
                <label><span>{{ $copy['contact'] }}</span><input name="contact_name" value="{{ old('contact_name') }}" required autocomplete="name"></label>
                <label><span>{{ $copy['job'] }}</span><input name="job_title" value="{{ old('job_title') }}"></label>
                <label><span>{{ $copy['email'] }}</span><input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" dir="ltr"></label>
                <label><span>{{ $copy['phone'] }}</span><input name="phone" value="{{ old('phone') }}" dir="ltr" autocomplete="tel"></label>
                <label><span>{{ $copy['country'] }}</span><input name="country" value="{{ old('country','Afghanistan') }}"></label>
                <label><span>{{ $copy['city'] }}</span><input name="city" value="{{ old('city') }}"></label>
                <label><span>{{ $copy['method'] }}</span><select name="procurement_method" required>@foreach(__('modern.rfq.methods') as $value=>$label)<option value="{{ $value }}" @selected(old('procurement_method','rfq')===$value)>{{ $label }}</option>@endforeach</select></label>
                <label><span>{{ $copy['ref'] }}</span><input name="procurement_reference" value="{{ old('procurement_reference') }}"></label>
                <label><span>{{ $copy['deadline'] }}</span><input type="date" name="submission_deadline" value="{{ old('submission_deadline') }}"></label>
                <label><span>{{ $copy['delivery'] }}</span><input name="delivery_location" value="{{ old('delivery_location') }}"></label>

                <fieldset class="mx-form-wide mx-checks">
                    <legend>{{ $copy['capabilities'] }}</legend>
                    <div class="mx-check-grid">
                        @foreach($capabilities as $capability)
                            <label>
                                <input type="checkbox" name="capabilities[]" value="{{ $capability['key'] }}" @checked(in_array($capability['key'], old('capabilities', []), true))>
                                <span><strong>{{ __("website.solutions.{$capability['key']}.title") }}</strong><small>{{ __("website.solutions.{$capability['key']}.description") }}</small></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <label><span>{{ $copy['budget'] }}, {{ __('modern.rfq.currency') }}</span><select name="budget_currency"><option value="">—</option>@foreach(['USD','AFN','EUR'] as $currency)<option value="{{ $currency }}" @selected(old('budget_currency')===$currency)>{{ $currency }}</option>@endforeach</select></label>
                <label><span>{{ $copy['timeline'] }}</span><input name="timeline" value="{{ old('timeline') }}" placeholder="{{ __('modern.rfq.timeline_placeholder') }}"></label>
                <label><span>{{ $copy['budget'] }}, {{ __('modern.rfq.min') }}</span><input type="number" min="0" step="0.01" name="budget_min" value="{{ old('budget_min') }}" dir="ltr"></label>
                <label><span>{{ $copy['budget'] }}, {{ __('modern.rfq.max') }}</span><input type="number" min="0" step="0.01" name="budget_max" value="{{ old('budget_max') }}" dir="ltr"></label>
                <label class="mx-form-wide"><span>{{ $copy['summary'] }}</span><textarea name="project_summary" rows="4" required>{{ old('project_summary') }}</textarea></label>
                <label class="mx-form-wide"><span>{{ $copy['scope'] }}</span><textarea name="scope_requirements" rows="7" required>{{ old('scope_requirements') }}</textarea></label>
                <label class="mx-form-wide"><span>{{ $copy['compliance'] }}</span><textarea name="compliance_requirements" rows="4">{{ old('compliance_requirements') }}</textarea></label>
                <label class="mx-form-wide mx-file"><span>{{ $copy['document'] }} <small>{{ __('modern.rfq.file_hint') }}</small></span><input type="file" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"></label>
                <label class="mx-form-wide mx-consent"><input type="checkbox" name="privacy_accepted" value="1" required @checked(old('privacy_accepted'))><span>{{ $copy['privacy'] }}</span></label>
            </div>
            <p class="mx-note">{{ $copy['note'] }}</p>
            <button class="mx-button mx-button-primary" type="submit">{{ $copy['submit'] }}</button>
        </form>
    </div>
</section>

@include('marketing.partials.mx-faq', ['faqs' => $faqs, 'title' => __('modern.rfq.faq_title'), 'description' => ''])
@endsection
