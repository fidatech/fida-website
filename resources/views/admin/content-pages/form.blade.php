@php
    $locales = config('website.locales');
    $contentTypes = config('website.content_types');
    $selectedType = old('type', $contentPage->type ?: 'page');
    $selectedTypeDefinition = $contentTypes[$selectedType] ?? $contentTypes['page'];
@endphp
<section class="editor-heading">
    <div><a href="{{ route('admin.content-pages.index', ['type' => $selectedType]) }}">← {{ $selectedTypeDefinition['label'] }}</a><h1>{{ $contentPage->exists ? $contentPage->translation('title', 'en') : 'New '.$selectedTypeDefinition['singular'] }}</h1><p>{{ $contentPage->exists ? '/'.$contentPage->slug : $selectedTypeDefinition['description'] }}</p></div>
    <div class="editor-actions">
        @if($contentPage->exists && $contentPage->status === 'published')<a class="console-button console-button-quiet" href="{{ route('pages.show', $contentPage) }}" target="_blank">Preview ↗</a>@endif
        <button class="console-button console-button-primary" type="submit">{{ $submitLabel }} <span>✓</span></button>
    </div>
</section>

<div class="editor-layout">
    <section class="console-card editor-main">
        <header class="language-tabs" role="tablist">
            @foreach($locales as $locale => $config)
                <button @class(['active' => $loop->first]) type="button" data-language-tab="{{ $locale }}" role="tab"><b>{{ strtoupper($locale) }}</b>{{ $config['label'] }}@if($locale !== 'en')<i>{{ $config['direction'] }}</i>@endif</button>
            @endforeach
        </header>

        @foreach($locales as $locale => $config)
            <div @class(['language-panel', 'active' => $loop->first]) data-language-panel="{{ $locale }}" @if(!$loop->first) hidden @endif>
                <div class="form-section-head"><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div><h2>{{ $config['native'] }} content</h2><p>Page copy shown to {{ $config['label'] }} visitors.</p></div></div>
                <div class="console-form">
                    <label class="field-wide"><span>Page title @if($locale === 'en')<b>Required</b>@endif</span><input name="title[{{ $locale }}]" value="{{ old("title.$locale", $contentPage->title[$locale] ?? '') }}" @if($locale === 'en') required @endif dir="{{ $config['direction'] }}"></label>
                    <label class="field-wide"><span>Eyebrow</span><input name="eyebrow[{{ $locale }}]" value="{{ old("eyebrow.$locale", $contentPage->eyebrow[$locale] ?? '') }}" dir="{{ $config['direction'] }}" placeholder="Short context above the title"></label>
                    <label class="field-wide"><span>Summary</span><textarea name="summary[{{ $locale }}]" rows="3" dir="{{ $config['direction'] }}">{{ old("summary.$locale", $contentPage->summary[$locale] ?? '') }}</textarea></label>
                    <label class="field-wide"><span>Page body <b>Safe HTML</b></span><textarea class="code-editor" name="body[{{ $locale }}]" rows="15" dir="{{ $config['direction'] }}" spellcheck="false">{{ old("body.$locale", $contentPage->body[$locale] ?? '') }}</textarea><small>Allowed for trusted editors: headings, paragraphs, lists, strong text and links. Scripts and embedded objects are blocked.</small></label>
                </div>
                <div class="seo-box">
                    <header><span>◎</span><div><h3>Search & AI discovery</h3><p>Concise facts help search engines and answer systems understand this page.</p></div></header>
                    <div class="console-form two-columns">
                        <label><span>Primary search topic</span><input name="primary_query[{{ $locale }}]" maxlength="190" value="{{ old("primary_query.$locale", $contentPage->primary_query[$locale] ?? '') }}" dir="{{ $config['direction'] }}" placeholder="The one topic this page should answer"><small>Planning field only—never printed as a meta-keywords tag.</small></label>
                        <label><span>Meta title</span><input name="meta_title[{{ $locale }}]" maxlength="190" value="{{ old("meta_title.$locale", $contentPage->meta_title[$locale] ?? '') }}" dir="{{ $config['direction'] }}" data-counted><small data-counter>0 / 60 recommended</small></label>
                        <label class="field-wide"><span>Meta description</span><textarea name="meta_description[{{ $locale }}]" rows="3" maxlength="320" dir="{{ $config['direction'] }}" data-counted>{{ old("meta_description.$locale", $contentPage->meta_description[$locale] ?? '') }}</textarea><small data-counter>0 / 160 recommended</small></label>
                    </div>
                </div>
                <div class="seo-box faq-editor-box">
                    <header><span>?</span><div><h3>Direct answers</h3><p>Add concise questions people may ask search engines or AI assistants. Only complete pairs are published.</p></div></header>
                    <div class="faq-editor-list">
                        @for($faqIndex = 0; $faqIndex < 4; $faqIndex++)
                            <fieldset class="faq-editor-item">
                                <legend>FAQ {{ str_pad((string) ($faqIndex + 1), 2, '0', STR_PAD_LEFT) }}</legend>
                                <div class="console-form two-columns">
                                    <label><span>Question</span><input name="metadata[faqs][{{ $faqIndex }}][question][{{ $locale }}]" maxlength="320" value="{{ old("metadata.faqs.$faqIndex.question.$locale", data_get($contentPage->metadata, "faqs.$faqIndex.question.$locale")) }}" dir="{{ $config['direction'] }}" placeholder="What does a customer need to know?"></label>
                                    <label><span>Answer</span><textarea name="metadata[faqs][{{ $faqIndex }}][answer][{{ $locale }}]" rows="3" maxlength="1500" dir="{{ $config['direction'] }}" placeholder="Give a factual, self-contained answer.">{{ old("metadata.faqs.$faqIndex.answer.$locale", data_get($contentPage->metadata, "faqs.$faqIndex.answer.$locale")) }}</textarea></label>
                                </div>
                            </fieldset>
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach

        <section class="discovery-controls">
            <div class="form-section-head"><span>AI</span><div><h2>Search, answer and generative discovery</h2><p>These controls apply consistently to classic search, AI results and shared previews.</p></div></div>
            <div class="console-form two-columns">
                <label><span>Search intent</span><select name="search_intent"><option value="">Choose the visitor's intent</option>@foreach(config('website.discovery.search_intents') as $intent => $label)<option value="{{ $intent }}" @selected(old('search_intent', $contentPage->search_intent) === $intent)>{{ $label }}</option>@endforeach</select></label>
                <label><span>Robots policy</span><select name="robots_directive">@foreach(config('website.discovery.robots') as $directive => $label)<option value="{{ $directive }}" @selected(old('robots_directive', $contentPage->robotsDirective()) === $directive)>{{ $label }}</option>@endforeach</select></label>
                <label class="field-wide"><span>Social preview image URL</span><input type="url" name="social_image_url" maxlength="2048" value="{{ old('social_image_url', $contentPage->social_image_url) }}" dir="ltr" placeholder="https://fida.af/storage/..."><small>A page-specific 1200×630 image; the global website image is used when empty.</small></label>
                <label><span>Author or responsible expert</span><input name="author_name" maxlength="120" value="{{ old('author_name', $contentPage->author_name) }}" placeholder="Verified public name"></label>
                <label><span>Editorial reviewer</span><input name="reviewer_name" maxlength="120" value="{{ old('reviewer_name', $contentPage->reviewer_name) }}" placeholder="Verified reviewer name"></label>
                <label><span>Last reviewed</span><input type="datetime-local" name="reviewed_at" value="{{ old('reviewed_at', $contentPage->reviewed_at?->format('Y-m-d\TH:i')) }}"></label>
            </div>
        </section>
    </section>

    <aside class="editor-sidebar">
        <section class="console-card publish-card">
            <header><small>PUBLICATION</small><span class="status status-{{ old('status', $contentPage->status ?: 'draft') }}">{{ old('status', $contentPage->status ?: 'draft') }}</span></header>
            <div class="console-form">
                <label><span>Status</span><select name="status"><option value="draft" @selected(old('status', $contentPage->status) === 'draft')>Draft</option><option value="published" @selected(old('status', $contentPage->status) === 'published')>Published</option></select></label>
                <label><span>Publish time</span><input type="datetime-local" name="published_at" value="{{ old('published_at', $contentPage->published_at?->format('Y-m-d\TH:i')) }}"></label>
                <label class="checkbox-row"><input type="checkbox" name="featured" value="1" @checked(old('featured', $contentPage->featured))><span>Feature this page</span></label>
            </div>
        </section>
        <section class="console-card settings-card">
            <header><small>PAGE SETTINGS</small></header>
            <div class="console-form">
                <label><span>URL slug</span><span class="slug-field"><b>/</b><input name="slug" required value="{{ old('slug', $contentPage->slug) }}" placeholder="page-url"></span>@error('slug')<small class="field-error">{{ $message }}</small>@enderror</label>
                <label><span>Content type</span><select name="type" required>@foreach($contentTypes as $type => $definition)<option value="{{ $type }}" @selected($selectedType === $type)>{{ $definition['singular'] }}</option>@endforeach</select><small>Controls where this content appears on the public website.</small></label>
                <label><span>Sort priority</span><input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $contentPage->sort_order ?? 0) }}"></label>
            </div>
        </section>
        <section class="console-card discovery-audit-card">
            <header><small>DISCOVERY READINESS</small><span class="audit-score audit-score-{{ $discoveryAudit['status'] }}">{{ $discoveryAudit['score'] }}%</span></header>
            <div class="audit-meter"><i style="width: {{ $discoveryAudit['score'] }}%"></i></div>
            <p>{{ $discoveryAudit['passed'] }} of {{ $discoveryAudit['total'] }} checks currently pass. Save changes to refresh the audit.</p>
            @if($discoveryAudit['issues'] !== [])
                <ul>@foreach(array_slice($discoveryAudit['issues'], 0, 7) as $issue)<li>{{ $issue['label'] }}</li>@endforeach</ul>
            @else
                <div class="audit-ready">✓ Ready for final editorial review</div>
            @endif
        </section>
        @if($errors->any())
            <section class="console-card error-list"><strong>Fix before saving</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></section>
        @endif
    </aside>
</div>
