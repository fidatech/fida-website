@extends('layouts.admin')
@section('title', $contract->exists ? 'Edit Contract' : 'Add Contract')
@section('eyebrow','CRM / contract record')
@section('content')
<section class="editor-heading"><div><a href="{{ route('admin.contracts.index') }}">← Contracts</a><h1>{{ $contract->exists ? $contract->title : 'New contract' }}</h1><p>Commercial scope, dates, amount, payment terms and signed-document archive.</p></div></section>
<form method="POST" enctype="multipart/form-data" action="{{ $contract->exists ? route('admin.contracts.update',$contract) : route('admin.contracts.store') }}">@csrf @if($contract->exists)@method('PUT')@endif
<section class="console-card admin-card-pad"><div class="console-form two-columns">
<label><span>Client</span><select name="client_id" required><option value="">Select client</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id',$contract->client_id)==$client->id)>{{ $client->company_name ?: $client->name }}</option>@endforeach</select></label>
<label><span>Project</span><select name="portfolio_project_id"><option value="">Not linked</option>@foreach($projects as $project)<option value="{{ $project->id }}" @selected(old('portfolio_project_id',$contract->portfolio_project_id)==$project->id)>{{ $project->name }}</option>@endforeach</select></label>
<label><span>Contract number</span><input name="contract_number" value="{{ old('contract_number',$contract->contract_number) }}"></label>
<label><span>Title</span><input name="title" value="{{ old('title',$contract->title) }}" required></label>
<label><span>Signed date</span><input type="date" name="signed_at" value="{{ old('signed_at',$contract->signed_at?->format('Y-m-d')) }}"></label>
<label><span>Status</span><select name="status">@foreach(['draft','active','completed','cancelled','expired'] as $status)<option value="{{ $status }}" @selected(old('status',$contract->status ?: 'active')===$status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
<label><span>Starts</span><input type="date" name="starts_at" value="{{ old('starts_at',$contract->starts_at?->format('Y-m-d')) }}"></label>
<label><span>Ends</span><input type="date" name="ends_at" value="{{ old('ends_at',$contract->ends_at?->format('Y-m-d')) }}"></label>
<label><span>Amount</span><input type="number" step="0.01" min="0" name="amount" value="{{ old('amount',$contract->amount) }}"></label>
<label><span>Currency</span><input name="currency" value="{{ old('currency',$contract->currency ?: 'AFN') }}" required></label>
</div><div class="console-form">
<label><span>Scope summary</span><textarea name="scope_summary" rows="6">{{ old('scope_summary',$contract->scope_summary) }}</textarea></label>
<label><span>Payment terms</span><textarea name="payment_terms" rows="5">{{ old('payment_terms',$contract->payment_terms) }}</textarea></label>
<label><span>Internal notes</span><textarea name="notes" rows="4">{{ old('notes',$contract->notes) }}</textarea></label>
<label><span>Contract attachment</span><input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">@if($contract->attachment_path)<small><a href="{{ route('admin.contracts.download',$contract) }}">Download current attachment</a></small><label class="checkbox-row"><input type="checkbox" name="remove_attachment" value="1"><span>Remove current attachment</span></label>@endif</label>
<button class="console-button console-button-primary" type="submit">Save contract</button>
</div></section></form>
@endsection
