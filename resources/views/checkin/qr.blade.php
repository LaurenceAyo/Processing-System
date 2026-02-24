@extends('checkin.layout')

@section('title', 'QR Code — ' . $serviceType->name)
@section('subtitle', 'Print and post this QR code at your service window')

@section('styles')
<style>
    .qr-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 2.5rem;
        max-width: 420px;
        margin: 0 auto;
        text-align: center;
    }

    .service-badge {
        display: inline-block;
        background: #0369a1;
        color: #e0f2fe;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        padding: 0.25rem 0.9rem;
        border-radius: 999px;
        margin-bottom: 1rem;
    }

    .qr-card h2 {
        font-size: 1.6rem;
        color: #f1f5f9;
        margin-bottom: 0.5rem;
    }

    .qr-card p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .qr-wrapper {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .qr-wrapper svg { display: block; }

    .scan-hint {
        font-size: 0.85rem;
        color: #38bdf8;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .url-box {
        background: #0f172a;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-size: 0.75rem;
        color: #475569;
        word-break: break-all;
        margin-bottom: 1.5rem;
    }

    .btn-group {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .btn {
        padding: 0.6rem 1.4rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn-print {
        background: #0ea5e9;
        color: #fff;
    }

    .btn-back {
        background: #1e293b;
        border: 1px solid #334155;
        color: #94a3b8;
    }

    @media print {
        header, .btn-group, .url-box, .scan-hint { display: none !important; }
        body { background: #fff; color: #000; }
        .qr-card { border: none; box-shadow: none; }
        .qr-card h2, .service-badge { color: #000 !important; }
    }
</style>
@endsection

@section('content')
<div class="qr-card">
    <span class="service-badge">{{ $serviceType->code }}</span>
    <h2>{{ $serviceType->name }}</h2>
    <p>Scan the QR code below with your phone to get your queue number instantly.</p>

    <div class="qr-wrapper">
        {!! $qrCode !!}
    </div>

    <div class="scan-hint">📱 Scan to check in</div>

    <div class="url-box">{{ $url }}</div>

    <div class="btn-group">
        <a href="{{ url('/qr') }}" class="btn btn-back">← Back</a>
        <button class="btn btn-print" onclick="window.print()">🖨 Print QR</button>
    </div>
</div>
@endsection
