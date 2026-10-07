@extends('layouts.admin')

@section('title', $client->exists ? 'Edit client' : 'Add client')
@section('eyebrow', 'CRM / client record')

@section('content')
<form method="POST" action="{{ $client->exists ? route('admin.clients.update', $client) : route('admin.clients.store') }}">
    @csrf
    @if($client->exists) @method('PUT') @endif

    <section class="editor-heading">
        <div><a href="{{ route('admin.clients.index') }}">← Clients</a><h1>{{ $client->exists ? ($client->company_name ?: $client->name) : 'New client' }}</h1><p>Keep the company profile, contact details and relationship notes in one record.</p></div>
        <div class="editor-actions">
            @if($client->exists)<a class="console-button console-button-quiet" href="{{ route('admin.contracts.create', ['client_id' => $client->id]) }}">New contract</a>@endif
            <button class="console-button console-button-primary" type="submit">Save client <span>✓</span></button>
        </div>
    </section>

    <div class="editor-layout">
        <section class="console-card editor-main">
            <div class="form-section-head"><span>01</span><div><h2>Client identity</h2><p>Organization and primary relationship details.</p></div></div>
            <div class="console-form two-columns">
                <label><span>Client / person name <b>Required</b></span><input name="name" value="{{ old('name', $client->name) }}" required></label>
                <label><span>Company name</span><input name="company_name" value="{{ old('company_name', $client->company_name) }}"></label>
                <label><span>Sector</span><input name="sector" value="{{ old('sector', $client->sector) }}"></label>
                <label><span>Status</span><select name="status">@foreach(['lead','active','inactive','completed'] as $status)<option value="{{ $status }}" @selected(old('status', $client->status ?: 'active') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
                <label><span>Contact person</span><input name="contact_person" value="{{ old('contact_person', $client->contact_person) }}"></label>
                <label><span>Email</span><input type="email" name="email" value="{{ old('email', $client->email) }}"></label>
                <label><span>Phone</span><input name="phone" value="{{ old('phone', $client->phone) }}"></label>
                <label><span>WhatsApp</span><input name="whatsapp" value="{{ old('whatsapp', $client->whatsapp) }}"></label>
                <label><span>Website</span><input name="website" value="{{ old('website', $client->website) }}"></label>
                <label><span>Address</span><textarea name="address" rows="3">{{ old('address', $client->address) }}</textarea></label>
            </div>
            <div class="seo-box"><header><span>✎</span><div><h3>Internal notes</h3><p>Private relationship context for the Fida team.</p></div></header><div class="console-form"><label><textarea name="notes" rows="7">{{ old('notes', $client->notes) }}</textarea></label></div></div>
        </section>

        @if($client->exists)
            <aside class="editor-sidebar">
                <section class="console-card settings-panel">
                    <header><div><small>DELIVERY</small><h2>Projects</h2></div><span class="settings-state">{{ $client->projects->count() }}</span></header>
                    <div class="settings-panel-body linked-records">
                        @forelse($client->projects as $project)<a href="{{ route('admin.projects.edit', $project) }}"><strong>{{ $project->name }}</strong><small>{{ $project->project_type ?: 'Project' }}</small><span>↗</span></a>@empty<p class="admin-help">No projects linked yet.</p>@endforelse
                    </div>
                </section>
                <section class="console-card settings-panel">
                    <header><div><small>COMMERCIAL</small><h2>Contracts</h2></div><span class="settings-state">{{ $client->contracts->count() }}</span></header>
                    <div class="settings-panel-body linked-records">
                        @forelse($client->contracts as $contract)<a href="{{ route('admin.contracts.edit', $contract) }}"><strong>{{ $contract->title }}</strong><small>{{ $contract->contract_number ?: 'No number' }}</small><span>↗</span></a>@empty<p class="admin-help">No contracts linked yet.</p>@endforelse
                    </div>
                </section>
            </aside>
        @endif
    </div>
</form>
@endsection
