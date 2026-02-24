@extends('checkin.layout')

@section('title', 'QR Codes — Office Queueing System')
@section('subtitle', 'Scan a QR code to get your queue number')

@section('styles')
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s, border-color 0.2s;
    }

    .card:hover {
        transform: translateY(-4px);
        border-color: #38bdf8;
    }

    .card .code-badge {
        display: inline-block;
        background: #0369a1;
        color: #e0f2fe;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        padding: 0.2rem 0.7rem;
        border-radius: 999px;
        margin-bottom: 0.8rem;
    }

    .card h2 {
        font-size: 1.1rem;
        color: #f1f5f9;
        margin-bottom: 0.4rem;
    }

    .card p {
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 1rem;
        min-height: 2.5em;
    }

    .card .btn {
        display: inline-block;
        background: #0ea5e9;
        color: #fff;
        padding: 0.45rem 1.2rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .card:hover .btn {
        background: #0284c7;
    }
</style>
@endsection

@section('content')
<p style="color:#64748b; margin-bottom:1.5rem;">
    Click a service below to view its printable QR code. Staff can print these and post them at the entrance.
</p>

<div class="grid">
    @foreach($serviceTypes as $type)
        <a href="{{ url('/qr/' . $type->id) }}" class="card">
            <span class="code-badge">{{ $type->code }}</span>
            <h2>{{ $type->name }}</h2>
            <p>{{ $type->description ?? '' }}</p>
            <span class="btn">View QR Code →</span>
        </a>
    @endforeach
</div>
@endsection
