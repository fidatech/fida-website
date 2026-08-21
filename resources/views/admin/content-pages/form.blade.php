@php
    $locales = config('website.locales');
    $translatableFields = ['title', 'eyebrow', 'summary', 'body', 'meta_title', 'meta_description'];
@endphp
<section class="editor-heading">
    <div><a href="{{ route('admin.content-pages.index') }}">← Content library</a><h1>{{ $contentPage->exists ? $contentPage->translation('title', 'en') : 'Untitled page' }}</h1><p>{{ $contentPage->exists ? '/'.$contentPage->slug : 'Build a search-ready page in three languages.' }}</p></div>
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
                        <label><span>Meta title</span><input name="meta_title[{{ $locale }}]" maxlength="190" value="{{ old("meta_title.$locale", $contentPage->meta_title[$locale] ?? '') }}" dir="{{ $config['direction'] }}" data-counted><small data-counter>0 / 60 recommended</small></label>
                        <label><span>Meta description</span><textarea name="meta_description[{{ $locale }}]" rows="3" maxlength="320" dir="{{ $config['direction'] }}" data-counted>{{ old("meta_description.$locale", $contentPage->meta_description[$locale] ?? '') }}</textarea><small data-counter>0 / 160 recommended</small></label>
                    </div>
                </div>
            </div>
        @endforeach
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
                <label><span>Content type</span><select name="type" required>@foreach(['solution', 'service', 'industry', 'case-study', 'article', 'page'] as $type)<option value="{{ $type }}" @selected(old('type', $contentPage->type ?: 'solution') === $type)>{{ Str::headline($type) }}</option>@endforeach</select></label>
                <label><span>Sort priority</span><input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $contentPage->sort_order ?? 0) }}"></label>
            </div>
        </section>
        @if($errors->any())
            <section class="console-card error-list"><strong>Fix before saving</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></section>
        @endif
    </aside>
</div>
