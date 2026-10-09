<!doctype html><html><body style="font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:24px;color:#111827">
<div style="max-width:760px;margin:auto;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb">
<div style="padding:22px 24px;background:#111319;color:#fff"><small style="color:#c9ff4a">FIDA TECHNOLOGIES · PROCUREMENT</small><h1 style="margin:8px 0 0;font-size:22px">New RFQ submission</h1></div>
<div style="padding:24px">
<p><strong>{{ $rfq->reference }}</strong> · {{ strtoupper($rfq->procurement_method) }}</p>
<table style="width:100%;border-collapse:collapse;font-size:14px">
<tr><td style="padding:7px;color:#6b7280">Organization</td><td>{{ $rfq->organization_name }} ({{ $rfq->organization_type }})</td></tr>
<tr><td style="padding:7px;color:#6b7280">Contact</td><td>{{ $rfq->contact_name }} · {{ $rfq->job_title ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Email</td><td>{{ $rfq->email }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Phone</td><td>{{ $rfq->phone ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Procurement ref.</td><td>{{ $rfq->procurement_reference ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Deadline</td><td>{{ $rfq->submission_deadline?->format('d M Y') ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Capabilities</td><td>{{ implode(', ', $rfq->capabilities ?? []) }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Budget</td><td>{{ $rfq->budget_currency ?: '' }} {{ $rfq->budget_min ?: '—' }} – {{ $rfq->budget_max ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Location</td><td>{{ $rfq->delivery_location ?: '—' }}</td></tr>
<tr><td style="padding:7px;color:#6b7280">Attachment</td><td>{{ $rfq->attachment_name ?: 'None' }}</td></tr>
</table>
<h3>Project summary</h3><p style="white-space:pre-wrap">{{ $rfq->project_summary }}</p>
<h3>Scope / technical requirements</h3><p style="white-space:pre-wrap">{{ $rfq->scope_requirements }}</p>
@if($rfq->compliance_requirements)<h3>Compliance / warranty / training</h3><p style="white-space:pre-wrap">{{ $rfq->compliance_requirements }}</p>@endif
<p style="margin-top:24px"><a href="{{ $adminUrl }}" style="display:inline-block;background:#111319;color:#fff;text-decoration:none;padding:12px 16px;border-radius:9px">Open RFQ in admin</a></p>
</div></div></body></html>