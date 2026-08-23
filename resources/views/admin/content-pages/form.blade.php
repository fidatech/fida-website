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
                @if($selectedType === 'service')
                    <div class="seo-box content-profile-box">
                        <header><span>SVC</span><div><h3>Service profile</h3><p>Structured facts shown on the dedicated service detail page.</p></div></header>
                        <div class="console-form two-columns">
                            <label><span>Engagement begins with</span><input name="metadata[service][engagement][{{ $locale }}]" maxlength="240" value="{{ old("metadata.service.engagement.$locale", data_get($contentPage->metadata, "service.engagement.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            <label><span>Delivery approach</span><input name="metadata[service][delivery][{{ $locale }}]" maxlength="240" value="{{ old("metadata.service.delivery.$locale", data_get($contentPage->metadata, "service.delivery.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            <label class="field-wide"><span>Handover or support boundary</span><input name="metadata[service][handover][{{ $locale }}]" maxlength="240" value="{{ old("metadata.service.handover.$locale", data_get($contentPage->metadata, "service.handover.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            @for($capabilityIndex = 0; $capabilityIndex < 4; $capabilityIndex++)
                                <label><span>Capability {{ $capabilityIndex + 1 }}</span><input name="metadata[service][capabilities][{{ $capabilityIndex }}][{{ $locale }}]" maxlength="190" value="{{ old("metadata.service.capabilities.$capabilityIndex.$locale", data_get($contentPage->metadata, "service.capabilities.$capabilityIndex.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            @endfor
                        </div>
                    </div>
                @endif
                @if($selectedType === 'product')
                    <div class="seo-box content-profile-box">
                        <header><span>SYS</span><div><h3>Product profile</h3><p>Confirmed platform facts and capability labels for the product detail page.</p></div></header>
                        <div class="console-form two-columns">
                            <label><span>Product category</span><input name="metadata[product][category][{{ $locale }}]" maxlength="190" value="{{ old("metadata.product.category.$locale", data_get($contentPage->metadata, "product.category.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            <label><span>Platform</span><input name="metadata[product][platform][{{ $locale }}]" maxlength="190" value="{{ old("metadata.product.platform.$locale", data_get($contentPage->metadata, "product.platform.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            <label><span>Deployment</span><input name="metadata[product][deployment][{{ $locale }}]" maxlength="190" value="{{ old("metadata.product.deployment.$locale", data_get($contentPage->metadata, "product.deployment.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            <label><span>Availability status</span><input name="metadata[product][status][{{ $locale }}]" maxlength="190" value="{{ old("metadata.product.status.$locale", data_get($contentPage->metadata, "product.status.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            @for($featureIndex = 0; $featureIndex < 6; $featureIndex++)
                                <label><span>Capability {{ $featureIndex + 1 }}</span><input name="metadata[product][features][{{ $featureIndex }}][{{ $locale }}]" maxlength="190" value="{{ old("metadata.product.features.$featureIndex.$locale", data_get($contentPage->metadata, "product.features.$featureIndex.$locale")) }}" dir="{{ $config['direction'] }}"></label>
                            @endfor
                        </div>
                    </div>
                @endif
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

        @if($selectedType === 'article')
            <section class="discovery-controls editorial-controls">
                <div class="form-section-head"><span>ED</span><div><h2>Insight editorial details</h2><p>Connect the article to a managed topic and a verified public author.</p></div></div>
                <div class="console-form two-columns">
                    <label><span>Article category</span><select name="article_category_id"><option value="">Uncategorized</option>@foreach($articleCategories as $articleCategory)<option value="{{ $articleCategory->id }}" @selected((string) old('article_category_id', $contentPage->article_category_id) === (string) $articleCategory->id)>{{ $articleCategory->translation('name', 'en') }}{{ $articleCategory->active ? '' : ' (inactive)' }}</option>@endforeach</select></label>
                    <label><span>Article author</span><select name="article_author_id"><option value="">Use the responsible expert field</option>@foreach($articleAuthors as $articleAuthor)<option value="{{ $articleAuthor->id }}" @selected((string) old('article_author_id', $contentPage->article_author_id) === (string) $articleAuthor->id)>{{ $articleAuthor->name }}{{ $articleAuthor->active ? '' : ' (inactive)' }}</option>@endforeach</select></label>
                </div>
            </section>
        @endif

        @if($selectedType === 'product')
            <section class="discovery-controls editorial-controls">
                <div class="form-section-head"><span>SYS</span><div><h2>Product identity</h2><p>Short code and safe accent color used by the existing 3D product profile.</p></div></div>
                <div class="console-form two-columns">
                    <label><span>Product code</span><input name="metadata[product][code]" maxlength="24" value="{{ old('metadata.product.code', data_get($contentPage->metadata, 'product.code')) }}" dir="ltr"></label>
                    <label><span>Accent color</span><input name="metadata[product][accent]" maxlength="7" value="{{ old('metadata.product.accent', data_get($contentPage->metadata, 'product.accent', '#c9ff4a')) }}" dir="ltr" placeholder="#c9ff4a"></label>
                </div>
            </section>
        @endif

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
        <section class="discovery-controls related-content-controls">
            <div class="form-section-head"><span>↗</span><div><h2>Intentional internal links</h2><p>Preferred related pages appear before automatic recommendations on the public detail page.</p></div></div>
            <div class="console-form">
                <label class="field-wide"><span>Related content</span><input type="hidden" name="metadata[related_slugs][]" value=""><select name="metadata[related_slugs][]" multiple size="8">@foreach($relatedOptions as $relatedOption)<option value="{{ $relatedOption->slug }}" @selected(in_array($relatedOption->slug, (array) old('metadata.related_slugs', data_get($contentPage->metadata, 'related_slugs', [])), true))>{{ strtoupper($relatedOption->type) }} · {{ $relatedOption->translation('title', 'en') }}{{ $relatedOption->status === 'published' ? '' : ' ('.$relatedOption->status.')' }}</option>@endforeach</select><small>Select up to eight factual next steps. Hold Ctrl or Command to select more than one.</small></label>
            </div>
        </section>
    </section>

    <aside class="editor-sidebar">
        <section class="console-card publish-card">
            <header><small>PUBLICATION</small><span class="status status-{{ old('status', $contentPage->status ?: 'draft') }}">{{ old('status', $contentPage->status ?: 'draft') }}</span></header>
            <div class="console-form">
                <label><span>Status</span><select name="status"><option value="draft" @selected(old('status', $contentPage->status) === 'draft')>Draft</option><option value="review" @selected(old('status', $contentPage->status) === 'review')>In review</option><option value="published" @selected(old('status', $contentPage->status) === 'published')>Published / scheduled</option></select></label>
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
