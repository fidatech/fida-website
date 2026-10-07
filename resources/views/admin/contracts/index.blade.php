@extends('layouts.admin')

@section('title', 'Contracts')
@section('eyebrow', 'CRM / agreements')

@section('content')
    <section class="page-heading">
        <div>
            <small class="section-code">01 / COMMERCIAL RECORDS</small>
            <h1>Every agreement, accounted for.</h1>
            <p>Keep contract scope, dates, value, payment terms and private signed files linked to the correct client and project.</p>
        </div>
        <a class="console-button console-button-primary" href="{{ route('admin.contracts.create') }}">Add contract <span>+</span></a>
    </section>

    <section class="console-card table-card">
        <div class="console-table-wrap">
            <table class="console-table">
                <thead><tr><th>Contract</th><th>Client</th><th>Project</th><th>Value</th><th>Status</th><th>Signed</th><th></th></tr></thead>
                <tbody>
                    @forelse($contracts as $contract)
                        <tr>
                            <td><a class="table-title" href="{{ route('admin.contracts.edit', $contract) }}"><strong>{{ $contract->title }}</strong><small>{{ $contract->contract_number ?: 'No contract number' }}</small></a></td>
                            <td>{{ $contract->client->company_name ?: $contract->client->name }}</td>
                            <td>{{ $contract->project?->name ?: '—' }}</td>
                            <td>{{ $contract->amount !== null ? number_format((float) $contract->amount, 2).' '.$contract->currency : '—' }}</td>
                            <td><span class="status status-{{ $contract->status === 'active' ? 'published' : ($contract->status === 'draft' ? 'draft' : 'review') }}">{{ $contract->status }}</span></td>
                            <td><time>{{ $contract->signed_at?->format('d M Y') ?: '—' }}</time></td>
                            <td><a class="row-action" href="{{ route('admin.contracts.edit', $contract) }}">↗</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i>◎</i><strong>No contracts recorded</strong><p>Add the next signed or active agreement here.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('admin.partials.pagination', ['paginator' => $contracts])
    </section>
@endsection
