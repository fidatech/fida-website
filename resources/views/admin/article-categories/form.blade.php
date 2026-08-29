@php($locales = config('website.locales'))
<section class="editor-heading"><div><a href="{{ route('admin.article-categories.index') }}">← Insight categories</a><h1>{{ $articleCategory->exists ? $articleCategory->translation('name', 'en') : 'New insight category' }}</h1><p>{{ $articleCategory->exists ? '/articles/category/'.$articleCategory->slug : 'Create a focused multilingual archive topic.' }}</p></div><button class="console-button console-button-primary" type="submit">{{ $submitLabel }} <span>✓</span></button></section>
<div class="editor-layout">
    <section class="console-card editor-main">
        @foreach($locales as $locale => $config)
            <div class="taxonomy-language-block"><div class="form-section-head"><span>{{ strtoupper($locale) }}</span><div><h2>{{ $config['native'] }}</h2><p>Category copy and search metadata.</p></div></div><div class="console-form">
                <label class="field-wide"><span>Name @if($locale === 'en')<b>Required</b>@endif</span><input name="name[{{ $locale }}]" value="{{ old("name.$locale", $articleCategory->name[$locale] ?? '') }}" dir="{{ $config['direction'] }}" @required($locale === 'en')></label>
                <label class="field-wide"><span>Description</span><textarea name="description[{{ $locale }}]" rows="3" dir="{{ $config['direction'] }}">{{ old("description.$locale", $articleCategory->description[$locale] ?? '') }}</textarea></label>
                <label class="field-wide"><span>Meta title</span><input name="meta_title[{{ $locale }}]" maxlength="190" value="{{ old("meta_title.$locale", $articleCategory->meta_title[$locale] ?? '') }}" dir="{{ $config['direction'] }}"></label>
                <label class="field-wide"><span>Meta description</span><textarea name="meta_description[{{ $locale }}]" rows="2" maxlength="320" dir="{{ $config['direction'] }}">{{ old("meta_description.$locale", $articleCategory->meta_description[$locale] ?? '') }}</textarea></label>
            </div></div>
        @endforeach
    </section>
    <aside class="editor-sidebar"><section class="console-card settings-card"><header><small>CATEGORY SETTINGS</small></header><div class="console-form"><label><span>Slug</span><input name="slug" value="{{ old('slug', $articleCategory->slug) }}" required dir="ltr"></label><label><span>Sort priority</span><input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $articleCategory->sort_order ?? 0) }}"></label><label class="checkbox-row"><input type="checkbox" name="active" value="1" @checked(old('active', $articleCategory->exists ? $articleCategory->active : true))><span>Public archive active</span></label></div></section>@if($errors->any())<section class="console-card error-list"><strong>Fix before saving</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></section>@endif</aside>
</div>
