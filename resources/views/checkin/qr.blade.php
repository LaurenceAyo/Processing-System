@extends('checkin.layout')

@section('title', 'QR Code — ' . $serviceType->name)
@section('subtitle', 'Print and post this QR code at your service window')

@section('styles')
<style>
    .qr-card {
        position: relative;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem 2.5rem 2.5rem;
        max-width: 440px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
        box-shadow: 0 0 0 1px rgba(56,189,248,0.05), 0 32px 64px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    .qr-card::before {
        content: '';
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 55%;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--accent) 50%, transparent);
        opacity: 0.4;
    }

    .qr-card::after {
        content: '';
        position: absolute;
        top: -80px; left: 50%;
        transform: translateX(-50%);
        width: 280px; height: 180px;
        background: radial-gradient(ellipse, rgba(14,165,233,0.07) 0%, transparent 70%);
        pointer-events: none;
    }

    .service-badge {
        position: relative; z-index: 1;
        display: inline-flex;
        align-items: center;
        background: rgba(3,105,161,0.25);
        border: 1px solid rgba(56,189,248,0.25);
        color: #7dd3fc;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 0.28rem 1rem;
        border-radius: 999px;
        margin-bottom: 1.25rem;
    }

    .qr-card h2 {
        position: relative; z-index: 1;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text);
        margin: 0 0 0.5rem;
        letter-spacing: -0.02em;
    }

    .qr-card .subtitle {
        position: relative; z-index: 1;
        color: var(--text-2);
        font-size: 0.875rem;
        margin: 0 0 2rem;
        line-height: 1.55;
    }

    .qr-wrapper {
        position: relative; z-index: 1;
        background: #fff;
        border-radius: 14px;
        padding: 1.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow:
            0 0 0 6px rgba(56,189,248,0.07),
            0 0 0 12px rgba(56,189,248,0.03),
            0 12px 32px rgba(0,0,0,0.45);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .qr-wrapper:hover {
        transform: scale(1.015);
        box-shadow:
            0 0 0 7px rgba(56,189,248,0.12),
            0 0 0 14px rgba(56,189,248,0.05),
            0 16px 40px rgba(0,0,0,0.5);
    }

    .qr-wrapper svg { display: block; }

    .scan-hint {
        position: relative; z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        color: var(--accent);
        font-weight: 600;
        letter-spacing: 0.04em;
        margin-bottom: 1.5rem;
    }

    .url-box {
        position: relative; z-index: 1;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0.65rem 1rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        color: var(--text-3);
        word-break: break-all;
        margin-bottom: 2rem;
        text-align: left;
        line-height: 1.55;
    }

    .sep {
        position: relative; z-index: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border) 30%, var(--border) 70%, transparent);
        margin-bottom: 1.75rem;
    }

    .btn-group {
        position: relative; z-index: 1;
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1.5rem;
        border-radius: var(--radius-sm);
        font-family: 'Sora', sans-serif;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.18s ease;
    }

    .btn-print {
        background: linear-gradient(135deg, var(--accent-dk), var(--accent-dkr));
        color: #fff;
        box-shadow: 0 4px 16px rgba(14,165,233,0.28);
    }
    .btn-print:hover {
        box-shadow: 0 6px 24px rgba(14,165,233,0.42);
        transform: translateY(-1px);
    }

    .btn-back {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-2);
    }
    .btn-back:hover {
        border-color: rgba(56,189,248,0.2);
        color: var(--text);
        transform: translateY(-1px);
    }

    @media print {
        body { background: #fff; }
        .qr-card { background: #fff; border: none; box-shadow: none; padding: 1rem; }
        .qr-card::before, .qr-card::after { display: none; }
        header, .btn-group, .url-box, .scan-hint, .sep { display: none !important; }
        .qr-card h2 { color: #000 !important; }
        .service-badge { color: #0369a1 !important; border-color: #0369a1 !important; background: transparent !important; }
        .qr-card .subtitle { color: #555 !important; }
        .qr-wrapper { box-shadow: none; border: 2px solid #e2e8f0; }
    }
</style>
@endsection

@section('content')
<div class="qr-card">
    <span class="service-badge">{{ $serviceType->code }}</span>
    <h2>{{ $serviceType->name }}</h2>
    <p class="subtitle">Scan the QR code below with your phone to get your queue number instantly.</p>

    <div class="qr-wrapper">
        {!! $qrCode !!}
    </div>

    <div class="scan-hint">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="17" r="1"/></svg>
        Scan to check in
    </div>

    <div class="url-box">{{ $url }}</div>

    <div class="sep"></div>

    <div class="btn-group">
        <a href="{{ url('/qr') }}" class="btn btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back
        </a>
        <button class="btn btn-print" onclick="window.print()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Print QR
        </button>
    </div>
</div>
@endsection