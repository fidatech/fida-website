@extends('layouts.admin')

@section('title', $project->exists ? 'Edit project' : 'Add project')
@section('eyebrow', 'Portfolio / project record')

@section('content')
<form method="POST" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
    @csrf
    @if($project->exists) @method('PUT') @endif

    <section class="editor-heading">
        <div><a href="{{ route('admin.projects.index') }}">← Projects</a><h1>{{ $project->exists ? $project->name : 'New project' }}</h1><p>Delivery record, technology stack, client relationship, public content link and approved visual assets.</p></div>
        <button class="console-button console-button-primary" type="submit">Save project <span>✓</span></button>
    </section>

    <div class="editor-layout">
        <section class="console-card editor-main">
            <div class="form-section-head"><span>01</span><div><h2>Project details</h2><p>Core identity and delivery status.</p></div></div>
            <div class="console-form two-columns">
                <label><span>Name <b>Required</b></span><input name="name" value="{{ old('name', $project->name) }}" required></label>
                <label><span>Slug</span><input name="slug" value="{{ old('slug', $project->slug) }}" placeholder="auto-from-name"></label>
                <label><span>Client</span><select name="client_id"><option value="">No client / internal</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id', $project->client_id) == $client->id)>{{ $client->company_name ?: $client->name }}</option>@endforeach</select></label>
                <label><span>Project type</span><input name="project_type" value="{{ old('project_type', $project->project_type) }}" placeholder="ERP, website, mobile app…"></label>
                <label><span>Status</span><select name="status">@foreach(['planning','active','on_hold','completed','maintenance','archived'] as $status)<option value="{{ $status }}" @selected(old('status', $project->status ?: 'active') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>@endforeach</select></label>
                <label><span>Public content link</span><select name="content_page_id"><option value="">None</option>@foreach($contentPages as $page)<option value="{{ $page->id }}" @selected(old('content_page_id', $project->content_page_id) == $page->id)>{{ strtoupper($page->type) }} · {{ $page->translation('title', 'en') }}</option>@endforeach</select></label>
                <label><span>Started</span><input type="date" name="started_at" value="{{ old('started_at', $project->started_at?->format('Y-m-d')) }}"></label>
                <label><span>Completed</span><input type="date" name="completed_at" value="{{ old('completed_at', $project->completed_at?->format('Y-m-d')) }}"></label>
                <label><span>Live URL</span><input name="live_url" value="{{ old('live_url', $project->live_url) }}"></label>
                <label><span>Repository URL</span><input name="repository_url" value="{{ old('repository_url', $project->repository_url) }}"></label>
            </div>

            <div class="seo-box"><header><span>02</span><div><h3>Technology & summary</h3><p>Describe what was built and how.</p></div></header><div class="console-form">
                <label><span>Technologies</span><textarea name="technologies_text" rows="3" placeholder="Laravel, Flutter, MySQL, Bootstrap">{{ old('technologies_text', implode(', ', $project->technologies ?? [])) }}</textarea></label>
                <label><span>Short summary</span><textarea name="summary" rows="4">{{ old('summary', $project->summary) }}</textarea></label>
                <label><span>Internal / portfolio description</span><textarea name="description" rows="7">{{ old('description', $project->description) }}</textarea></label>
                <label class="checkbox-row"><input type="checkbox" name="public" value="1" @checked(old('public', $project->public))><span>Approved for public portfolio use</span></label>
            </div></div>
        </section>

        @if($project->exists)
            <aside class="editor-sidebar">
                <section class="console-card settings-panel">
                    <header><div><small>VISUAL ASSETS</small><h2>Screenshots</h2></div><span class="settings-state">{{ $project->screenshots->count() }}</span></header>
                    <form class="settings-panel-body console-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.projects.screenshots.store', $project) }}">
                        @csrf
                        <label><span>Upload screenshots</span><input type="file" name="screenshots[]" multiple accept="image/jpeg,image/png,image/webp" required><small>JPG, PNG or WebP. You can select multiple files.</small></label>
                        <button class="console-button console-button-primary" type="submit">Upload <span>+</span></button>
                    </form>
                </section>
            </aside>
        @endif
    </div>
</form>

@if($project->exists && $project->screenshots->isNotEmpty())
    <section class="console-card settings-panel project-gallery-panel">
        <header><div><small>PROJECT GALLERY</small><h2>Uploaded screenshots</h2></div></header>
        <div class="settings-panel-body project-shot-grid">
            @foreach($project->screenshots as $shot)
                <article>
                    <img src="{{ route('admin.projects.screenshots.show', $shot) }}" alt="{{ $project->name }} screenshot">
                    <form method="POST" action="{{ route('admin.projects.screenshots.destroy', $shot) }}">@csrf @method('DELETE')<button type="submit">Remove</button></form>
                </article>
            @endforeach
        </div>
    </section>
@endif
@endsection
