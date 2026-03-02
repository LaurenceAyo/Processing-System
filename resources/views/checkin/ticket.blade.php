@extends('checkin.layout')

@section('title', 'Your Ticket — ' . $ticket->ticket_number)
@section('subtitle', 'You are now in the queue!')

@section('styles')
<style>
    .ticket-card {
        position: relative;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2.75rem 2.5rem 2.5rem;
        max-width: 440px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
        box-shadow: 0 0 0 1px rgba(56,189,248,0.05), 0 24px 56px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    .ticket-card::before {
        content: '';
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 55%;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--green) 50%, transparent);
        opacity: 0.4;
    }

    .ticket-card::after {
        content: '';
        position: absolute;
        top: -80px; left: 50%;
        transform: translateX(-50%);
        width: 280px; height: 180px;
        background: radial-gradient(ellipse, rgba(52,211,153,0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Service header */
    .service-header {
        position: relative; z-index: 1;
        margin-bottom: 2rem;
    }

    .service-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.14em;
        margin-bottom: 0.3rem;
    }

    .service-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--accent);
        letter-spacing: -0.01em;
    }

    /* Big number */
    .ticket-number-wrap {
        position: relative; z-index: 1;
        margin-bottom: 0.5rem;
    }

    .ticket-number {
        font-size: clamp(5rem, 18vw, 6.5rem);
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
        line-height: 1;
        display: block;
    }

    .ticket-label {
        position: relative; z-index: 1;
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        margin-bottom: 1.5rem;
    }

    /* Status badge */
    .status-badge {
        position: relative; z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--green-bg);
        border: 1px solid var(--green-border);
        color: var(--green);
        padding: 0.32rem 1.1rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        margin-bottom: 1.75rem;
    }

    .status-dot {
        width: 6px; height: 6px;
        background: var(--green);
        border-radius: 50%;
        animation: pulse 1.8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    /* Divider – dashed ticket-tear style */
    .divider {
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        gap: 0;
        margin: 0 -2.5rem 1.75rem;
    }

    .divider::before, .divider::after {
        content: '';
        width: 22px; height: 22px;
        background: var(--bg);
        border-radius: 50%;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }

    .divider-line {
        flex: 1;
        border-top: 2px dashed var(--border);
        margin: 0 4px;
    }

    /* Stats */
    .queue-info {
        position: relative; z-index: 1;
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        margin-bottom: 1.75rem;
    }

    .stat { text-align: center; }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
        letter-spacing: -0.02em;
    }

    .stat-label {
        font-size: 0.72rem;
        font-weight: 500;
        color: var(--text-3);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 0.35rem;
    }

    .stat-divider {
        width: 1px;
        background: var(--border);
        align-self: stretch;
    }

    /* Hint */
    .hint {
        position: relative; z-index: 1;
        font-size: 0.83rem;
        color: var(--text-2);
        line-height: 1.6;
        padding: 1rem 1.25rem;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        margin-bottom: 1.5rem;
    }

    .hint strong { color: var(--text); font-weight: 600; }

    /* Time */
    .time-issued {
        position: relative; z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        color: var(--text-3);
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<div class="ticket-card">
    <div class="service-header">
        <div class="service-label">Service</div>
        <div class="service-name">{{ $serviceType->name }}</div>
    </div>

    <div class="ticket-number-wrap">
        <span class="ticket-number">{{ $ticket->ticket_number }}</span>
    </div>
    <div class="ticket-label">Your Queue Number</div>

    <div class="status-badge">
        <span class="status-dot"></span>
        Checked In — Waiting
    </div>

    <div class="divider">
        <div class="divider-line"></div>
    </div>

    <div class="queue-info">
        <div class="stat">
            <div class="stat-value">{{ $ticket->sequence_number }}</div>
            <div class="stat-label">Your Position</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat">
            <div class="stat-value">{{ $ahead }}</div>
            <div class="stat-label">Ahead of You</div>
        </div>
    </div>

    <div class="hint">
        Please <strong>watch the display monitor</strong> in the waiting area.<br>
        You will be called when it's your turn.
    </div>

    <div class="time-issued">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Issued at {{ $ticket->created_at->format('h:i A') }}
    </div>
</div>
@endsection