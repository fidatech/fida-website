<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>RFQ received</title></head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,sans-serif;color:#111827;">
<div style="max-width:680px;margin:0 auto;padding:28px 16px;">
    <div style="background:#111319;color:#f9fafb;border-radius:14px;padding:24px;">
        <div style="font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#c9ff4a;">Fida Technologies</div>
        <h1 style="margin:8px 0 12px;font-size:24px;">Your RFQ has been received.</h1>
        <p style="margin:0;color:#d1d5db;line-height:1.6;">Thank you for submitting your procurement requirement. Your reference is <strong style="color:#fff;">{{ $rfq->reference }}</strong>.</p>
    </div>
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;margin-top:12px;padding:24px;">
        <p style="margin:0 0 12px;line-height:1.65;">Project: <strong>{{ $rfq->project_title }}</strong></p>
        <p style="margin:0 0 12px;line-height:1.65;">Organization: <strong>{{ $rfq->organization }}</strong></p>
        <p style="margin:0;color:#4b5563;line-height:1.65;">Our team will review the scope, technical requirements, attached documents and deadline before responding. Please keep the reference number in future communication.</p>
        <p style="margin:18px 0 0;color:#4b5563;">Procurement contact: <a href="mailto:info@fida.af">info@fida.af</a></p>
    </div>
</div>
</body>
</html>
