@extends('layouts.admin')

@section('title', 'Auto Articles')
@section('eyebrow', 'Growth / daily publishing')

@section('content')
<section class="editor-heading">
    <div><small class="section-code">AI EDITORIAL AUTOMATION</small><h1>Daily article engine</h1><p>Generate useful English, Dari and Pashto articles from Search Console opportunities while avoiding duplicate topics.</p></div>
    <form method="POST" action="{{ route('admin.auto-articles.generate') }}">@csrf<button class="console-button console-button-primary" type="submit">Generate now ↗</button></form>
</section>

<div class="admin-grid-two">
    <section class="console-card">
        <header><div><small>Schedule & guardrails</small><h2>Automation settings</h2></div></header>
        <form class="console-form admin-card-pad" method="POST" action="{{ route('admin.auto-articles.update') }}">
            @csrf @method('PUT')
            <label class="checkbox-row"><input type="checkbox" name="enabled" value="1" @checked($settings['enabled'])><span>Enable daily generation</span></label>
            <label class="checkbox-row"><input type="checkbox" name="auto_publish" value="1" @checked($settings['auto_publish'])><span>Publish automatically instead of sending to review</span></label>
            <label><span>Daily time <b>Asia/Kabul</b></span><input type="time" name="daily_time" value="{{ old('daily_time', $settings['daily_time']) }}" required></label>
            <label><span>Default category</span><select name="category_id"><option value="">Business Software Planning</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int)$settings['category_id']===$category->id)>{{ $category->translation('name','en') }}</option>@endforeach</select></label>
            <label><span>Editorial themes</span><textarea name="themes" rows="8" required>{{ old('themes', $settings['themes']) }}</textarea><small>Use this as the editorial boundary. Search Console demand is considered automatically.</small></label>
            <button class="console-button console-button-primary" type="submit">Save automation</button>
        </form>
    </section>

    <section class="console-card admin-card-pad">
        <div class="growth-status">
            <span class="{{ $aiConfigured ? 'status-good' : 'status-warn' }}">{{ $aiConfigured ? 'AI READY' : 'AI KEY REQUIRED' }}</span>
            <h2>{{ $settings['enabled'] ? 'Daily engine enabled' : 'Automation is currently off' }}</h2>
            <p>Generated articles use the existing multilingual content engine, sitemap controls, internal-link validation and IndexNow workflow.</p>
            <dl>
                <div><dt>Last generated</dt><dd>{{ $settings['last_generated_on'] ?: 'Never' }}</dd></div>
                <div><dt>Mode</dt><dd>{{ $settings['auto_publish'] ? 'Auto publish' : 'Review first' }}</dd></div>
                <div><dt>Last error</dt><dd>{{ $settings['last_error'] ?: 'None' }}</dd></div>
            </dl>
        </div>
    </section>
</div>

<section class="console-card table-card">
    <header><div><small>Automation history</small><h2>Recent generated articles</h2></div></header>
    <div class="analytics-table-wrap"><table data-datatable data-page-size="10"><thead><tr><th data-sort>Article</th><th data-sort>Status</th><th data-sort>Updated</th><th></th></tr></thead><tbody>
    @forelse($recent as $page)<tr><td><strong>{{ $page->translation('title','en') }}</strong><small>/{{ $page->slug }}</small></td><td>{{ strtoupper($page->status) }}</td><td data-value="{{ $page->updated_at->timestamp }}">{{ $page->updated_at->diffForHumans() }}</td><td><a href="{{ route('admin.content-pages.edit',$page) }}">Edit ↗</a></td></tr>@empty<tr><td colspan="4">No automated articles yet.</td></tr>@endforelse
    </tbody></table></div>
</section>
@endsection
