@extends('layouts.admin')
@section('title', $client->exists ? 'Edit Client' : 'Add Client')
@section('eyebrow','CRM / client record')
@section('content')
<section class="editor-heading"><div><a href="{{ route('admin.clients.index') }}">← Clients</a><h1>{{ $client->exists ? ($client->company_name ?: $client->name) : 'New client' }}</h1><p>Company profile, primary contact and relationship notes.</p></div>@if($client->exists)<a class="console-button console-button-primary" href="{{ route('admin.contracts.create',['client_id'=>$client->id]) }}">New contract ↗</a>@endif</section>
<form method="POST" action="{{ $client->exists ? route('admin.clients.update',$client) : route('admin.clients.store') }}">@csrf @if($client->exists)@method('PUT')@endif
<section class="console-card admin-card-pad"><div class="console-form two-columns">
<label><span>Client / person name</span><input name="name" value="{{ old('name',$client->name) }}" required></label>
<label><span>Company name</span><input name="company_name" value="{{ old('company_name',$client->company_name) }}"></label>
<label><span>Sector</span><input name="sector" value="{{ old('sector',$client->sector) }}"></label>
<label><span>Status</span><select name="status">@foreach(['lead','active','inactive','completed'] as $status)<option value="{{ $status }}" @selected(old('status',$client->status ?: 'active')===$status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
<label><span>Contact person</span><input name="contact_person" value="{{ old('contact_person',$client->contact_person) }}"></label>
<label><span>Email</span><input type="email" name="email" value="{{ old('email',$client->email) }}"></label>
<label><span>Phone</span><input name="phone" value="{{ old('phone',$client->phone) }}"></label>
<label><span>WhatsApp</span><input name="whatsapp" value="{{ old('whatsapp',$client->whatsapp) }}"></label>
<label><span>Website</span><input name="website" value="{{ old('website',$client->website) }}"></label>
<label><span>Address</span><textarea name="address" rows="3">{{ old('address',$client->address) }}</textarea></label>
</div><div class="console-form"><label><span>Internal notes</span><textarea name="notes" rows="6">{{ old('notes',$client->notes) }}</textarea></label><button class="console-button console-button-primary" type="submit">Save client</button></div></section></form>
@if($client->exists)<div class="admin-grid-two">
<section class="console-card table-card"><header><div><small>Delivery</small><h2>Projects</h2></div></header><div class="analytics-table-wrap"><table><tbody>@forelse($client->projects as $project)<tr><td><strong>{{ $project->name }}</strong><small>{{ $project->project_type }}</small></td><td><a href="{{ route('admin.projects.edit',$project) }}">Open ↗</a></td></tr>@empty<tr><td>No projects linked.</td></tr>@endforelse</tbody></table></div></section>
<section class="console-card table-card"><header><div><small>Commercial</small><h2>Contracts</h2></div></header><div class="analytics-table-wrap"><table><tbody>@forelse($client->contracts as $contract)<tr><td><strong>{{ $contract->title }}</strong><small>{{ $contract->contract_number ?: 'No number' }}</small></td><td><a href="{{ route('admin.contracts.edit',$contract) }}">Open ↗</a></td></tr>@empty<tr><td>No contracts linked.</td></tr>@endforelse</tbody></table></div></section>
</div>@endif
@endsection
