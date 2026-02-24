@extends('checkin.layout')

@section('title', 'Your Ticket — ' . $ticket->ticket_number)
@section('subtitle', 'You are now in the queue!')

@section('styles')
<style>
    .ticket-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        max-width: 420px;
        margin: 0 auto;
        text-align: center;
    }

    .service-label {
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.4rem;
    }

    .service-name {
        font-size: 1.1rem;
        color: #38bdf8;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .ticket-number {
        font-size: 5rem;
        font-weight: 800;
        color: #f1f5f9;
        letter-spacing: 0.04em;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .ticket-label {
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 2rem;
    }

    .divider {
        border: none;
        border-top: 1px dashed #334155;
        margin: 1.5rem 0;
    }

    .queue-info {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .queue-info .stat {
        text-align: center;
    }

    .queue-info .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #f1f5f9;
    }

    .queue-info .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.2rem;
    }

    .status-badge {
        display: inline-block;
        background: #14532d;
        color: #86efac;
        padding: 0.3rem 1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .hint {
        font-size: 0.82rem;
        color: #475569;
        line-height: 1.5;
    }

    .hint strong {
        color: #94a3b8;
    }

    .time-issued {
        font-size: 0.75rem;
        color: #334155;
        margin-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="ticket-card">
    <div class="service-label">Service</div>
    <div class="service-name">{{ $serviceType->name }}</div>

    <div class="ticket-number">{{ $ticket->ticket_number }}</div>
    <div class="ticket-label">Your Queue Number</div>

    <span class="status-badge">✅ Checked In — Waiting</span>

    <hr class="divider">

    <div class="queue-info">
        <div class="stat">
            <div class="stat-value">{{ $ticket->sequence_number }}</div>
            <div class="stat-label">Your Number</div>
        </div>
        <div class="stat">
            <div class="stat-value">{{ $ahead }}</div>
            <div class="stat-label">Ahead of You</div>
        </div>
    </div>

    <p class="hint">
        Please <strong>watch the display monitor</strong> in the waiting area.<br>
        You will be called when it's your turn.
    </p>

    <div class="time-issued">Issued at {{ $ticket->created_at->format('h:i A') }}</div>
</div>
@endsection
