@extends('checkin.layout')

@section('title', 'Check In — ' . $serviceType->name)
@section('subtitle', 'One tap to get your queue number')

@section('styles')
<style>
    .confirm-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        max-width: 400px;
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

    .confirm-card h2 {
        font-size: 1.7rem;
        font-weight: 800;
        color: #f1f5f9;
        margin-bottom: 0.5rem;
    }

    .confirm-card p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .btn-checkin {
        display: block;
        width: 100%;
        background: #0ea5e9;
        color: #fff;
        font-size: 1.15rem;
        font-weight: 700;
        padding: 0.9rem;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        letter-spacing: 0.02em;
    }

    .btn-checkin:hover  { background: #0284c7; }
    .btn-checkin:active { transform: scale(0.97); }

    .warning {
        margin-top: 1.2rem;
        font-size: 0.78rem;
        color: #475569;
    }
</style>
@endsection

@section('content')
<div class="confirm-card">
    <span class="service-badge">{{ $serviceType->code }}</span>
    <h2>{{ $serviceType->name }}</h2>
    <p>Tap the button below to receive your queue number. Please only check in once.</p>

    <form method="POST" action="{{ url('/checkin/' . $serviceType->id) }}">
        @csrf
        <button class="btn-checkin" type="submit">🎟 Get My Ticket</button>
    </form>

    <p class="warning">⚠️ Each tap generates a new ticket number.</p>
</div>
@endsection
