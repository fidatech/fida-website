<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New website lead</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:680px;margin:0 auto;padding:28px 16px;">
        <div style="background:#111319;color:#f9fafb;border-radius:14px 14px 0 0;padding:22px 24px;">
            <div style="font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#c9ff4a;">Fida Technologies</div>
            <h1 style="margin:8px 0 0;font-size:24px;">New website lead</h1>
        </div>
        <div style="background:#fff;border:1px solid #e5e7eb;border-top:0;border-radius:0 0 14px 14px;padding:24px;">
            <p style="margin:0 0 18px;font-size:14px;color:#4b5563;">A new lead was submitted from fida.af.</p>
            <table role="presentation" style="width:100%;border-collapse:collapse;font-size:14px;">
                <tr><td style="padding:8px 0;color:#6b7280;width:150px;">Name</td><td style="padding:8px 0;font-weight:700;">{{ $lead->name }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Email</td><td style="padding:8px 0;">{{ $lead->email ?: '—' }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Phone</td><td style="padding:8px 0;">{{ $lead->phone ?: '—' }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Company</td><td style="padding:8px 0;">{{ $lead->company ?: '—' }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Project type</td><td style="padding:8px 0;">{{ $lead->project_type ?: '—' }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Budget</td><td style="padding:8px 0;">{{ $lead->budget ?: '—' }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7280;">Page</td><td style="padding:8px 0;word-break:break-all;">{{ $lead->source_url ?: '—' }}</td></tr>
            </table>

            @if($lead->message)
                <div style="margin:18px 0 0;padding:16px;background:#f9fafb;border-radius:10px;">
                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin-bottom:7px;">Message</div>
                    <div style="font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $lead->message }}</div>
                </div>
            @endif

            <div style="margin-top:22px;">
                <a href="{{ $adminUrl }}" style="display:inline-block;padding:12px 18px;border-radius:10px;background:#111319;color:#fff;text-decoration:none;font-weight:700;">Open lead in admin</a>
            </div>
        </div>
    </div>
</body>
</html>
