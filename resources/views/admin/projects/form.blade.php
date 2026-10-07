@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'Add Project')
@section('eyebrow','Portfolio / project record')
@section('content')
<section class="editor-heading"><div><a href="{{ route('admin.projects.index') }}">← Projects</a><h1>{{ $project->exists ? $project->name : 'New project' }}</h1><p>Delivery record, technology stack, public linkage and approved screenshots.</p></div></section>
<form method="POST" action="{{ $project->exists ? route('admin.projects.update',$project) : route('admin.projects.store') }}">@csrf @if($project->exists)@method('PUT')@endif
<section class="console-card admin-card-pad"><div class="console-form two-columns">
<label><span>Name</span><input name="name" value="{{ old('name',$project->name) }}" required></label>
<label><span>Slug</span><input name="slug" value="{{ old('slug',$project->slug) }}" placeholder="auto-from-name"></label>
<label><span>Client</span><select name="client_id"><option value="">No client / internal</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id',$project->client_id)==$client->id)>{{ $client->company_name ?: $client->name }}</option>@endforeach</select></label>
<label><span>Project type</span><input name="project_type" value="{{ old('project_type',$project->project_type) }}" placeholder="ERP, website, mobile app..."></label>
<label><span>Status</span><select name="status">@foreach(['planning','active','on_hold','completed','maintenance','archived'] as $status)<option value="{{ $status }}" @selected(old('status',$project->status ?: 'active')===$status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>@endforeach</select></label>
<label><span>Public content link</span><select name="content_page_id"><option value="">None</option>@foreach($contentPages as $page)<option value="{{ $page->id }}" @selected(old('content_page_id',$project->content_page_id)==$page->id)>{{ strtoupper($page->type) }} · {{ $page->translation('title','en') }}</option>@endforeach</select></label>
<label><span>Started</span><input type="date" name="started_at" value="{{ old('started_at',$project->started_at?->format('Y-m-d')) }}"></label>
<label><span>Completed</span><input type="date" name="completed_at" value="{{ old('completed_at',$project->completed_at?->format('Y-m-d')) }}"></label>
<label><span>Live URL</span><input name="live_url" value="{{ old('live_url',$project->live_url) }}"></label>
<label><span>Repository URL</span><input name="repository_url" value="{{ old('repository_url',$project->repository_url) }}"></label>
</div><div class="console-form">
<label><span>Technologies</span><textarea name="technologies_text" rows="3" placeholder="Laravel, Flutter, MySQL, Bootstrap">{{ old('technologies_text', implode(', ', $project->technologies ?? [])) }}</textarea></label>
<label><span>Short summary</span><textarea name="summary" rows="4">{{ old('summary',$project->summary) }}</textarea></label>
<label><span>Internal / portfolio description</span><textarea name="description" rows="7">{{ old('description',$project->description) }}</textarea></label>
<label class="checkbox-row"><input type="checkbox" name="public" value="1" @checked(old('public',$project->public))><span>Approved for public portfolio use</span></label>
<button class="console-button console-button-primary" type="submit">Save project</button>
</div></section></form>

@if($project->exists)
<section class="console-card admin-card-pad"><div class="form-section-head"><span>IMG</span><div><h2>Project screenshots</h2><p>Upload multiple JPG, PNG or WebP screenshots. These remain managed through the admin until you explicitly use them publicly.</p></div></div>
<form class="console-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.projects.screenshots.store',$project) }}">@csrf<label><span>Screenshots</span><input type="file" name="screenshots[]" multiple accept="image/jpeg,image/png,image/webp" required></label><button class="console-button console-button-primary" type="submit">Upload screenshots</button></form>
@if($project->screenshots->isNotEmpty())<div class="project-shot-grid">@foreach($project->screenshots as $shot)<article><img src="{{ route('admin.projects.screenshots.show',$shot) }}" alt=""><form method="POST" action="{{ route('admin.projects.screenshots.destroy',$shot) }}">@csrf @method('DELETE')<button type="submit">Remove</button></form></article>@endforeach</div>@endif
</section>
@endif
@endsection
