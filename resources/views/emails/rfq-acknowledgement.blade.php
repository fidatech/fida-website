<!doctype html>
<html lang="en">
<body style="font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:24px;color:#111827">
<div style="max-width:680px;margin:auto;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb">
    <div style="padding:22px 24px;background:#111319;color:#fff">
        <small style="color:#c9ff4a">FIDA TECHNOLOGIES · PROCUREMENT</small>
        <h1 style="margin:8px 0 0;font-size:22px">Your request has been received</h1>
    </div>
    <div style="padding:24px">
        <p>Hello {{ $rfq->contact_name }},</p>
        <p>Thank you for sending your {{ strtoupper($rfq->procurement_method) }} to Fida Technologies. Your request has been recorded for review.</p>
        <div style="margin:20px 0;padding:16px;border-radius:10px;background:#f9fafb;border:1px solid #e5e7eb">
            <div style="font-size:12px;color:#6b7280">Fida reference</div>
            <div style="margin-top:5px;font-size:20px;font-weight:700">{{ $rfq->reference }}</div>
        </div>
        <p>Our team will review the submitted scope, technical requirements, deadline and procurement information before confirming the next commercial or technical step.</p>
        <p>If you need to add information, reply to this email and include the reference above.</p>
        <p style="margin-top:24px">Fida Technologies<br><a href="mailto:{{ config('website.procurement_email') }}">{{ config('website.procurement_email') }}</a><br>{{ config('website.phone') }}</p>
    </div>
</div>
</body>
</html>
