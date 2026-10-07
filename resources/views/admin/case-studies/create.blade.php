@extends('layouts.admin')

@section('title', 'Guided case study')
@section('eyebrow', 'Growth / case study interview')

@section('content')
<form method="POST" action="{{ route('admin.case-studies.generate') }}">
    @csrf

    <section class="editor-heading">
        <div><a href="{{ route('admin.case-studies.index') }}">← Case studies</a><h1>Build the story from verified facts.</h1><p>Answer the interview below. The AI will prepare a multilingual review draft without inventing outcomes, metrics or client details.</p></div>
        <button class="console-button console-button-primary" type="submit">Generate draft <span>✦</span></button>
    </section>

    <div class="editor-layout">
        <section class="console-card editor-main">
            <div class="form-section-head"><span>01</span><div><h2>Project context</h2><p>Identify the work and how the client may be referenced.</p></div></div>
            <div class="console-form two-columns">
                <label><span>Existing client</span><select name="client_id"><option value="">None / not recorded yet</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->company_name ?: $client->name }}</option>@endforeach</select></label>
                <label><span>Existing project</span><select name="portfolio_project_id"><option value="">None / not recorded yet</option>@foreach($projects as $project)<option value="{{ $project->id }}" @selected(old('portfolio_project_id') == $project->id)>{{ $project->name }} @if($project->client) · {{ $project->client->company_name ?: $project->client->name }}@endif</option>@endforeach</select></label>
                <label><span>Project name <b>Required</b></span><input name="project_name" value="{{ old('project_name') }}" required></label>
                <label><span>Industry <b>Required</b></span><input name="industry" value="{{ old('industry') }}" placeholder="Finance, pharmacy, mining…" required></label>
                <label><span>Client display name</span><input name="client_display_name" value="{{ old('client_display_name') }}" placeholder="Only if approved for public use"></label>
                <label class="checkbox-row"><input type="checkbox" name="keep_client_private" value="1" @checked(old('keep_client_private'))><span>Keep the client anonymous</span></label>
            </div>

            <div class="seo-box"><header><span>02</span><div><h3>Before Fida</h3><p>Describe the real operational problem and previous process.</p></div></header><div class="console-form">
                <label><span>What problem did the client have? <b>Required</b></span><textarea name="problem" rows="6" required>{{ old('problem') }}</textarea></label>
                <label><span>How were they working before?</span><textarea name="previous_process" rows="4">{{ old('previous_process') }}</textarea></label>
            </div></div>

            <div class="seo-box"><header><span>03</span><div><h3>What Fida delivered</h3><p>Modules, workflows, platforms and implementation.</p></div></header><div class="console-form">
                <label><span>Verified delivery scope <b>Required</b></span><textarea name="scope" rows="7" required placeholder="Modules, workflows, platforms, integrations, languages, deployment…">{{ old('scope') }}</textarea></label>
                <label><span>Implementation approach</span><textarea name="implementation" rows="6">{{ old('implementation') }}</textarea></label>
                <label><span>Technologies / platform</span><textarea name="technologies" rows="3">{{ old('technologies') }}</textarea></label>
                <label><span>Timeline</span><input name="timeline" value="{{ old('timeline') }}"></label>
            </div></div>

            <div class="seo-box"><header><span>04</span><div><h3>Verified outcomes</h3><p>Only include facts and metrics you can support.</p></div></header><div class="console-form">
                <label><span>What changed after delivery? <b>Required</b></span><textarea name="outcomes" rows="6" required>{{ old('outcomes') }}</textarea></label>
                <label><span>Measurable results</span><textarea name="measurable_results" rows="4" placeholder="Only real numbers you can prove. Leave blank otherwise.">{{ old('measurable_results') }}</textarea></label>
                <label><span>Approved testimonial</span><textarea name="testimonial" rows="4">{{ old('testimonial') }}</textarea></label>
                <label><span>Internal notes</span><textarea name="notes" rows="4">{{ old('notes') }}</textarea></label>
            </div></div>
        </section>

        <aside class="editor-sidebar">
            <section class="console-card settings-panel">
                <header><div><small>PUBLICATION SAFETY</small><h2>Review required</h2></div><span class="settings-state">DRAFT</span></header>
                <div class="settings-panel-body">
                    <div class="ai-provider-note"><strong>No automatic publication</strong><p>The generated case study opens in review status. Client permission, evidence, screenshots and final wording still need approval before publication.</p></div>
                </div>
            </section>
        </aside>
    </div>
</form>
@endsection
