@extends('checkin.layout')

@section('title', 'Check In — ' . $serviceType->name)
@section('subtitle', 'One tap to get your queue number')

@section('styles')
<style>
    .confirm-card {
        position: relative;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem 2.5rem 2.5rem;
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
        box-shadow: 0 0 0 1px rgba(56,189,248,0.05), 0 24px 56px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    .confirm-card::before {
        content: '';
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 55%;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--accent) 50%, transparent);
        opacity: 0.35;
    }

    .confirm-card::after {
        content: '';
        position: absolute;
        top: -80px; left: 50%;
        transform: translateX(-50%);
        width: 260px; height: 160px;
        background: radial-gradient(ellipse, rgba(14,165,233,0.06) 0%, transparent 70%);
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

    .confirm-card h2 {
        position: relative; z-index: 1;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .confirm-card .desc {
        position: relative; z-index: 1;
        color: var(--text-2);
        font-size: 0.875rem;
        margin-bottom: 2.25rem;
        line-height: 1.6;
    }

    /* ── Ticket icon illustration ── */
    .ticket-icon {
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 72px; height: 72px;
        margin: 0 auto 1.75rem;
        background: rgba(14,165,233,0.1);
        border: 1px solid rgba(56,189,248,0.2);
        border-radius: 18px;
    }

    .ticket-icon svg { color: var(--accent); }

    /* ── Button ── */
    .btn-checkin {
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        background: linear-gradient(135deg, var(--accent-dk), var(--accent-dkr));
        color: #fff;
        font-family: 'Sora', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        padding: 1rem;
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
        letter-spacing: 0.01em;
        box-shadow: 0 6px 24px rgba(14,165,233,0.3);
        transition: box-shadow 0.2s, transform 0.15s;
    }

    .btn-checkin:hover {
        box-shadow: 0 8px 32px rgba(14,165,233,0.45);
        transform: translateY(-1px);
    }
    .btn-checkin:active { transform: scale(0.98); }

    .warning {
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        margin-top: 1.25rem;
        font-size: 0.78rem;
        color: var(--text-3);
    }
</style>
@endsection

@section('content')
<div class="confirm-card">
    <span class="service-badge">{{ $serviceType->code }}</span>

    <div class="ticket-icon">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 9a3 3 0 1 1 0-6v15a3 3 0 1 1 0 6"/>
            <path d="M22 9a3 3 0 0 0 0-6v15a3 3 0 0 0 0 6"/>
            <rect x="2" y="3" width="20" height="18" rx="2"/>
            <path d="M9 12h6M9 8h6M9 16h4"/>
        </svg>
    </div>

    <h2>{{ $serviceType->name }}</h2>
    <p class="desc">Tap the button below to receive your queue number. Please only check in once.</p>

    <form method="POST" action="{{ url('/checkin/' . $serviceType->id) }}">
        @csrf
        <button class="btn-checkin" type="submit">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9a3 3 0 1 1 0-6v15a3 3 0 1 1 0 6"/><path d="M22 9a3 3 0 0 0 0-6v15a3 3 0 0 0 0 6"/><rect x="2" y="3" width="20" height="18" rx="2"/></svg>
            Get My Ticket
        </button>
    </form>

    <p class="warning">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Each tap generates a new ticket number.
    </p>
</div>
@endsection