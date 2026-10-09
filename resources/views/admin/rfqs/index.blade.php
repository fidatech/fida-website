@extends('layouts.admin')
@section('title','RFQs')
@section('eyebrow','Procurement')
@section('content')
<div class="console-page-head">
    <div><small>FORMAL PROCUREMENT INTAKE</small><h1>RFQs, RFPs & tenders</h1><p>Requests submitted from the public procurement channel.</p></div>
</div>
<section class="console-card">
    <div class="table-responsive">
        <table class="console-table">
            <thead><tr><th>Reference</th><th>Organization</th><th>Method</th><th>Deadline</th><th>Status</th><th>Received</th><th></th></tr></thead>
            <tbody>
            @forelse($rfqs as $rfq)
                <tr>
                    <td><strong>{{ $rfq->reference }}</strong><small>{{ $rfq->procurement_reference }}</small></td>
                    <td>{{ $rfq->organization_name }}<small>{{ $rfq->contact_name }} · {{ $rfq->email }}</small></td>
                    <td>{{ strtoupper($rfq->procurement_method) }}</td>
                    <td>{{ $rfq->submission_deadline?->format('d M Y') ?: '—' }}</td>
                    <td><span class="status-pill">{{ ucfirst($rfq->status) }}</span></td>
                    <td>{{ $rfq->created_at->format('d M Y · H:i') }}</td>
                    <td><a class="table-action" href="{{ route('admin.rfqs.show',$rfq) }}">Open ↗</a></td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="analytics-empty">No RFQs received yet.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $rfqs->links() }}
</section>
@endsection