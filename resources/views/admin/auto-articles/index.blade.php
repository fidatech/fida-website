@extends('layouts.admin')

@section('title', 'Auto articles')
@section('eyebrow', 'Growth / multilingual publishing')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / EDITORIAL AUTOMATION</small>
            <h1>Generate useful drafts on schedule.</h1>
            <p>Use Search Console demand, existing website content and your editorial themes to create English, Dari and Pashto drafts. AI drafts never publish automatically; a human review gate protects quality and search compliance.</p>
        </div>
        <form method="POST" action="{{ route('admin.auto-articles.generate') }}">
            @csrf
            <button class="console-button console-button-primary" type="submit">Generate article <span>✦</span></button>
        </form>
    </section>

    <div class="website-settings-layout">
        <div class="website-settings-main">
            <section class="console-card settings-panel">
                <header>
                    <div><small>AUTOMATION CONTROL</small><h2>Daily draft generation</h2></div>
                    <span class="settings-state">{{ $settings['enabled'] ? 'ACTIVE' : 'PAUSED' }}</span>
                </header>
                <form class="settings-panel-body console-form" method="POST" action="{{ route('admin.auto-articles.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="checkbox-row">
                        <input type="checkbox" name="enabled" value="1" @checked($settings['enabled'])>
                        <span>Enable daily article generation</span>
                    </label>

                    <div class="ai-provider-note">
                        <strong>Human review is mandatory</strong>
                        <p>Generated articles are saved as In review. Before publication, confirm usefulness/originality, verify factual and current claims, review Dari/Pashto localization, and record the responsible author and reviewer.</p>
                    </div>

                    <div class="console-form two-columns">
                        <label>
                            <span>Daily time <b>Asia/Kabul</b></span>
                            <input type="time" name="daily_time" value="{{ old('daily_time', $settings['daily_time']) }}" required>
                        </label>
                        <label>
                            <span>Default category</span>
                            <select name="category_id">
                                <option value="">Business Software Planning</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected((int) $settings['category_id'] === $category->id)>{{ $category->translation('name', 'en') }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <label>
                        <span>Editorial themes</span>
                        <textarea name="themes" rows="7" required>{{ old('themes', $settings['themes']) }}</textarea>
                        <small>These themes set the editorial boundary. Search Console opportunities and existing content are checked automatically.</small>
                    </label>

                    <div>
                        <button class="console-button console-button-primary" type="submit">Save automation <span>✓</span></button>
                    </div>
                </form>
            </section>

            <section class="console-card table-card">
                <header>
                    <div><small>RECENT OUTPUT</small><h2>Generated articles</h2></div>
                </header>
                <div class="console-table-wrap">
                    <table class="console-table">
                        <thead><tr><th>Article</th><th>Status</th><th>Updated</th><th></th></tr></thead>
                        <tbody>
                            @forelse($recent as $page)
                                <tr>
                                    <td><a class="table-title" href="{{ route('admin.content-pages.edit', $page) }}"><strong>{{ $page->translation('title', 'en') }}</strong><small>/{{ $page->slug }}</small></a></td>
                                    <td><span class="status status-{{ $page->publicationStatus() }}">{{ $page->publicationStatus() }}</span></td>
                                    <td><time>{{ $page->updated_at->diffForHumans() }}</time></td>
                                    <td><a class="row-action" href="{{ route('admin.content-pages.edit', $page) }}">↗</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4"><div class="empty-state"><i>✦</i><strong>No automated articles yet</strong><p>Generate one now or let the daily schedule create the first review draft.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside class="website-settings-side">
            <section class="console-card settings-panel">
                <header>
                    <div><small>AI CONNECTION</small><h2>Generation status</h2></div>
                    <span class="settings-state">{{ $aiConfigured ? 'READY' : 'NOT CONNECTED' }}</span>
                </header>
                <div class="settings-panel-body console-form">
                    <div class="ai-provider-note">
                        <strong>{{ $aiConfigured ? 'AI provider is ready' : 'Connect an AI API key' }}</strong>
                        <p>{{ $aiConfigured ? 'The article engine can generate multilingual drafts using your configured provider.' : 'Open Brand & settings and add a Gemini, OpenRouter or OpenAI API key before generating drafts.' }}</p>
                    </div>
                    @unless($aiConfigured)
                        <a class="console-button console-button-primary" href="{{ route('admin.settings.edit') }}">Open AI settings <span>↗</span></a>
                    @endunless
                </div>
            </section>

            <section class="console-card settings-panel">
                <header><div><small>LAST RUN</small><h2>Automation health</h2></div></header>
                <div class="settings-panel-body">
                    <div class="admin-fact-list">
                        <div><span>Last generated</span><strong>{{ $settings['last_generated_on'] ?: 'Never' }}</strong></div>
                        <div><span>Publishing mode</span><strong>Human review required</strong></div>
                        <div><span>Daily time</span><strong>{{ $settings['daily_time'] }} Kabul</strong></div>
                    </div>
                    @if($settings['last_error'])
                        <div class="ai-provider-note danger-note"><strong>Last error</strong><p>{{ $settings['last_error'] }}</p></div>
                    @endif
                </div>
            </section>
        </aside>
    </div>
@endsection
