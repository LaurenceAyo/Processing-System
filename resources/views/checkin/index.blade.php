@extends('checkin.layout')

@section('title', 'QR Codes — Office Queueing System')
@section('subtitle', 'Scan a QR code to get your queue number')

@section('styles')
<style>
    .intro {
        color: var(--text-2);
        font-size: 0.875rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* ── Grid ── */
    .service-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 1.25rem;
    }

    /* ── Card ── */
    .service-card {
        position: relative;
        display: flex;
        flex-direction: column;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.75rem 1.5rem 1.5rem;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
        transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
    }

    .service-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(56,189,248,0.06), transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .service-card:hover {
        border-color: var(--border-hi);
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(56,189,248,0.08);
    }

    .service-card:hover::before { opacity: 1; }

    /* Code badge */
    .code-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(3, 105, 161, 0.25);
        border: 1px solid rgba(56, 189, 248, 0.2);
        color: var(--accent);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.25rem 0.8rem;
        border-radius: 999px;
        margin-bottom: 1rem;
        width: fit-content;
    }

    /* Card title */
    .service-card h2 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.4rem;
        letter-spacing: -0.01em;
        line-height: 1.3;
    }

    /* Card description */
    .service-card .desc {
        font-size: 0.8rem;
        color: var(--text-2);
        line-height: 1.55;
        flex: 1;
        margin-bottom: 1.25rem;
        min-height: 2.5em;
    }

    /* CTA button */
    .card-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        background: var(--accent-dk);
        color: #fff;
        padding: 0.55rem 1rem;
        border-radius: var(--radius-sm);
        font-size: 0.82rem;
        font-weight: 700;
        transition: background 0.2s;
        width: 100%;
    }

    .service-card:hover .card-btn {
        background: var(--accent-dkr);
    }

    .card-btn svg { flex-shrink: 0; }
</style>
@endsection

@section('content')
<p class="intro">
    Click a service below to view its printable QR code. Staff can print these and post them at the entrance.
</p>

<div class="service-grid">
    @foreach($serviceTypes as $type)
        <a href="{{ url('/qr/' . $type->id) }}" class="service-card">
            <span class="code-badge">{{ $type->code }}</span>
            <h2>{{ $type->name }}</h2>
            <p class="desc">{{ $type->description ?? '' }}</p>
            <span class="card-btn">
                View QR Code
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
        </a>
    @endforeach
</div>
@endsection