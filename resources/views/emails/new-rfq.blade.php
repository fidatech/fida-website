<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>New RFQ</title></head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,sans-serif;color:#111827;">
<div style="max-width:720px;margin:0 auto;padding:28px 16px;">
    <div style="background:#111319;color:#f9fafb;border-radius:14px 14px 0 0;padding:22px 24px;">
        <div style="font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#c9ff4a;">Fida Technologies · Procurement</div>
        <h1 style="margin:8px 0 0;font-size:24px;">New RFQ {{ $rfq->reference }}</h1>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-top:0;border-radius:0 0 14px 14px;padding:24px;">
        <p style="margin:0 0 18px;font-size:14px;color:#4b5563;">A formal quotation request was submitted through fida.af.</p>
        <table role="presentation" style="width:100%;border-collapse:collapse;font-size:14px;">
            <tr><td style="padding:8px 0;color:#6b7280;width:170px;">Organization</td><td style="padding:8px 0;font-weight:700;">{{ $rfq->organization }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Organization type</td><td style="padding:8px 0;">{{ Str::headline($rfq->organization_type) }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Contact</td><td style="padding:8px 0;">{{ $rfq->contact_name }}@if($rfq->job_title) · {{ $rfq->job_title }}@endif</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Email</td><td style="padding:8px 0;">{{ $rfq->email }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Phone</td><td style="padding:8px 0;">{{ $rfq->phone ?: '—' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Project</td><td style="padding:8px 0;font-weight:700;">{{ $rfq->project_title }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Procurement type</td><td style="padding:8px 0;">{{ Str::headline($rfq->procurement_type) }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Deadline</td><td style="padding:8px 0;">{{ $rfq->submission_deadline?->format('d M Y') ?: 'Not specified' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Location</td><td style="padding:8px 0;">{{ $rfq->location ?: '—' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6b7280;">Budget</td><td style="padding:8px 0;">{{ $rfq->budget ?: 'Not disclosed' }}</td></tr>
        </table>
        <div style="margin:18px 0 0;padding:16px;background:#f9fafb;border-radius:10px;">
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin-bottom:7px;">Requirements</div>
            <div style="font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $rfq->requirements }}</div>
        </div>
        @if(!empty($rfq->attachments))
            <div style="margin-top:18px;">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin-bottom:7px;">Documents</div>
                @foreach($rfq->attachments as $file)
                    <div style="font-size:13px;padding:4px 0;">• {{ $file['name'] }}</div>
                @endforeach
            </div>
        @endif
        <div style="margin-top:22px;">
            <a href="{{ $adminUrl }}" style="display:inline-block;padding:12px 18px;border-radius:10px;background:#111319;color:#fff;text-decoration:none;font-weight:700;">Review RFQ in admin</a>
        </div>
    </div>
</div>
</body>
</html>
