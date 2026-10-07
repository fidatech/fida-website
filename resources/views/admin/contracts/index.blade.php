@extends('layouts.admin')
@section('title','Contracts')
@section('eyebrow','CRM / agreements')
@section('content')
<section class="editor-heading"><div><small class="section-code">COMMERCIAL RECORDS</small><h1>Contracts</h1><p>Record every new agreement and connect it to the client and project.</p></div><a class="console-button console-button-primary" href="{{ route('admin.contracts.create') }}">Add contract ↗</a></section>
<section class="console-card table-card"><div class="analytics-table-wrap"><table data-datatable data-page-size="25"><thead><tr><th data-sort>Contract</th><th data-sort>Client</th><th data-sort>Project</th><th data-sort>Value</th><th data-sort>Status</th><th data-sort>Signed</th><th></th></tr></thead><tbody>
@forelse($contracts as $contract)<tr><td><strong>{{ $contract->title }}</strong><small>{{ $contract->contract_number ?: 'No number' }}</small></td><td>{{ $contract->client->company_name ?: $contract->client->name }}</td><td>{{ $contract->project?->name ?: '—' }}</td><td data-value="{{ $contract->amount ?? 0 }}">{{ $contract->amount !== null ? number_format((float)$contract->amount,2).' '.$contract->currency : '—' }}</td><td>{{ strtoupper($contract->status) }}</td><td>{{ $contract->signed_at?->format('Y-m-d') ?: '—' }}</td><td><a href="{{ route('admin.contracts.edit',$contract) }}">Open ↗</a></td></tr>@empty<tr><td colspan="7">No contracts yet.</td></tr>@endforelse
</tbody></table></div><div class="admin-card-pad">{{ $contracts->links() }}</div></section>
@endsection
