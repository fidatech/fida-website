@extends('layouts.admin')

@section('title', 'Guided Case Study')
@section('eyebrow', 'Growth / case study interview')

@section('content')
<section class="editor-heading"><div><a href="{{ route('admin.case-studies.index') }}">← Case studies</a><h1>Tell me what happened</h1><p>Answer with real facts. The AI will turn them into a multilingual draft, but publication remains blocked until your evidence/permission checklist is complete.</p></div></section>

<form method="POST" action="{{ route('admin.case-studies.generate') }}">@csrf
<div class="editor-layout">
<section class="console-card editor-main admin-card-pad">
    <div class="console-form two-columns">
        <label><span>Existing client</span><select name="client_id"><option value="">None / not recorded yet</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id')==$client->id)>{{ $client->company_name ?: $client->name }}</option>@endforeach</select></label>
        <label><span>Existing project</span><select name="portfolio_project_id"><option value="">None / not recorded yet</option>@foreach($projects as $project)<option value="{{ $project->id }}" @selected(old('portfolio_project_id')==$project->id)>{{ $project->name }} @if($project->client) · {{ $project->client->company_name ?: $project->client->name }}@endif</option>@endforeach</select></label>
        <label><span>Project name <b>Required</b></span><input name="project_name" value="{{ old('project_name') }}" required></label>
        <label><span>Industry <b>Required</b></span><input name="industry" value="{{ old('industry') }}" placeholder="Finance, pharmacy, mining..." required></label>
        <label><span>Client display name</span><input name="client_display_name" value="{{ old('client_display_name') }}" placeholder="Only if allowed to publish"></label>
        <label class="checkbox-row"><input type="checkbox" name="keep_client_private" value="1" @checked(old('keep_client_private'))><span>Keep the client anonymous</span></label>
    </div>
    <div class="console-form">
        <label><span>What problem did the client have? <b>Required</b></span><textarea name="problem" rows="6" required>{{ old('problem') }}</textarea></label>
        <label><span>How were they working before?</span><textarea name="previous_process" rows="4">{{ old('previous_process') }}</textarea></label>
        <label><span>What exactly did Fida deliver? <b>Required</b></span><textarea name="scope" rows="7" required placeholder="Modules, workflows, platforms, integrations, languages, deployment...">{{ old('scope') }}</textarea></label>
        <label><span>How was it implemented?</span><textarea name="implementation" rows="6">{{ old('implementation') }}</textarea></label>
        <label><span>What changed after delivery? <b>Required</b></span><textarea name="outcomes" rows="6" required>{{ old('outcomes') }}</textarea></label>
        <label><span>Verified measurable results</span><textarea name="measurable_results" rows="4" placeholder="Only real numbers you can prove. Leave blank otherwise.">{{ old('measurable_results') }}</textarea></label>
        <label><span>Technologies / platform</span><textarea name="technologies" rows="3">{{ old('technologies') }}</textarea></label>
        <label><span>Timeline</span><input name="timeline" value="{{ old('timeline') }}"></label>
        <label><span>Approved testimonial</span><textarea name="testimonial" rows="4">{{ old('testimonial') }}</textarea></label>
        <label><span>Internal notes</span><textarea name="notes" rows="4">{{ old('notes') }}</textarea></label>
    </div>
</section>
<aside class="editor-sidebar"><section class="console-card publish-card"><header><div><small>AI drafting</small><h3>Create review draft</h3></div></header><div class="console-form"><p class="admin-help">No case study is published automatically. The generated page opens in review status so you can edit it and complete the client/evidence approval checks.</p><button class="console-button console-button-primary" type="submit">Generate case study ↗</button></div></section></aside>
</div>
</form>
@endsection
