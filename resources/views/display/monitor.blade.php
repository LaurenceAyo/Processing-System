<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display — Office Queueing System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #050d1a;
            --surface:   #0d1f35;
            --border:    #1a3a5c;
            --accent:    #00d4ff;
            --accent2:   #7c3aed;
            --text:      #e2f0ff;
            --muted:     #4a7fa5;
            --green:     #22c55e;
            --amber:     #f59e0b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ── Header ── */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2.5rem;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        header .logo {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        header .clock {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text);
            font-variant-numeric: tabular-nums;
        }

        header .date {
            font-size: 0.85rem;
            color: var(--muted);
            text-align: right;
        }

        /* ── Main grid ── */
        .display-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 0;
            flex: 1;
            min-height: 0;
        }

        /* ── Now Serving (left) ── */
        .now-serving {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 3rem;
            border-right: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .now-serving::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 40%, rgba(0, 212, 255, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .serving-label {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.75rem;
        }

        .serving-counter {
            font-size: 1rem;
            color: var(--accent);
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
        }

        .ticket-number {
            font-size: clamp(6rem, 15vw, 12rem);
            font-weight: 900;
            line-height: 1;
            color: #fff;
            letter-spacing: -0.02em;
            text-shadow: 0 0 60px rgba(0, 212, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .ticket-number.flash {
            animation: flash-in 0.5s ease-out;
        }

        @keyframes flash-in {
            0%   { transform: scale(0.85); opacity: 0.3; color: var(--accent); }
            60%  { transform: scale(1.06); }
            100% { transform: scale(1);    opacity: 1; color: #fff; }
        }

        .service-type-tag {
            margin-top: 1.2rem;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: var(--accent);
            padding: 0.35rem 1.2rem;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .no-ticket {
            font-size: 1.4rem;
            color: var(--muted);
            font-weight: 300;
            letter-spacing: 0.05em;
        }

        /* ── Queue (right sidebar) ── */
        .queue-sidebar {
            display: flex;
            flex-direction: column;
            background: var(--surface);
        }

        .queue-sidebar .section-title {
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }

        .queue-list {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0;
        }

        .queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid rgba(26, 58, 92, 0.5);
            transition: background 0.2s;
            animation: slide-in 0.3s ease;
        }

        @keyframes slide-in {
            from { transform: translateX(20px); opacity: 0; }
            to   { transform: translateX(0);   opacity: 1; }
        }

        .queue-item:first-child {
            background: rgba(0, 212, 255, 0.05);
        }

        .queue-badge {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
        }

        .queue-meta {
            font-size: 0.75rem;
            color: var(--muted);
        }

        .position-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--border);
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .position-badge.next {
            background: rgba(0, 212, 255, 0.2);
            color: var(--accent);
        }

        .queue-empty {
            padding: 2rem 1.5rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
        }

        /* ── Counters row ── */
        .counters-row {
            display: flex;
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .counter-card {
            flex: 1;
            padding: 0.7rem 1.2rem;
            border-right: 1px solid var(--border);
            text-align: center;
        }

        .counter-card:last-child { border-right: none; }

        .counter-name {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .counter-ticket {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--green);
            margin-top: 0.1rem;
        }

        .counter-ticket.empty { color: var(--muted); font-size: 0.9rem; font-weight: 400; }

        /* ── Status bar ── */
        .status-bar {
            padding: 0.4rem 2rem;
            background: #030914;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.72rem;
            color: var(--muted);
        }

        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--muted);
        }
        .status-dot.connected { background: var(--green); box-shadow: 0 0 6px var(--green); }
        .status-dot.error     { background: #ef4444; }

        /* Scrollbar */
        .queue-list::-webkit-scrollbar { width: 4px; }
        .queue-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
    </style>
</head>
<body>

<header>
    <div class="logo">🏢 Office Queueing System</div>
    <div style="text-align:right">
        <div class="clock" id="clock">--:--:--</div>
        <div class="date" id="date-label"></div>
    </div>
</header>

<div class="display-grid">
    <!-- Now Serving -->
    <div class="now-serving">
        <div class="serving-label">Now Serving</div>
        <div class="serving-counter" id="serving-counter">—</div>
        <div class="ticket-number" id="ticket-number">—</div>
        <div class="service-type-tag" id="service-type-tag" style="display:none"></div>
        <div class="no-ticket" id="no-ticket-msg">Waiting for next client...</div>
    </div>

    <!-- Queue Sidebar -->
    <div class="queue-sidebar">
        <div class="section-title">📋 Queue — Next Up</div>
        <div class="queue-list" id="queue-list">
            <div class="queue-empty">Loading queue...</div>
        </div>
    </div>
</div>

<!-- Counters Row -->
<div class="counters-row" id="counters-row">
    <div class="counter-card"><div class="counter-name">Loading...</div></div>
</div>

<!-- Status Bar -->
<div class="status-bar">
    <div class="status-dot" id="status-dot"></div>
    <span id="status-text">Connecting to real-time server...</span>
</div>

<!-- Reverb config passed from server -->
<script>
    const REVERB_APP_KEY  = '{{ env("REVERB_APP_KEY") }}';
    const REVERB_HOST     = '{{ env("REVERB_HOST", "localhost") }}';
    const REVERB_PORT     = {{ env("REVERB_PORT", 8080) }};
    const REVERB_SCHEME   = '{{ env("REVERB_SCHEME", "http") }}';
    const API_BASE        = '/api';
</script>

<!-- Laravel Echo + Pusher-js via CDN (no build step needed) -->
<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

<script>
// ─── Clock ────────────────────────────────────────────────────────
function updateClock() {
    const now = new Date();
    document.getElementById('clock').textContent =
        now.toLocaleTimeString('en-PH', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
    document.getElementById('date-label').textContent =
        now.toLocaleDateString('en-PH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}
setInterval(updateClock, 1000);
updateClock();

// ─── State (track last-rendered values) ──────────────────────────
let countersData      = {};
let lastTicketNumber  = null;   // only re-render Now Serving if this changes
let lastCounterName   = null;
let lastQueueHash     = null;   // only re-render queue list if this changes
let lastCountersHash  = null;   // only re-render counters bar if this changes

// ─── Status bar ──────────────────────────────────────────────────
function setStatus(connected, text) {
    document.getElementById('status-dot').className = 'status-dot ' + (connected ? 'connected' : 'error');
    document.getElementById('status-text').textContent = text;
}

// ─── Now Serving — only repaints if ticket changed ───────────────
function renderNowServing(ticket, counterName) {
    const newNum = ticket ? ticket.ticket_number : null;
    if (newNum === lastTicketNumber && counterName === lastCounterName) return; // no change
    lastTicketNumber = newNum;
    lastCounterName  = counterName;

    const numEl   = document.getElementById('ticket-number');
    const counter = document.getElementById('serving-counter');
    const tag     = document.getElementById('service-type-tag');
    const noMsg   = document.getElementById('no-ticket-msg');

    if (ticket) {
        numEl.textContent  = ticket.ticket_number;
        numEl.classList.remove('flash');
        void numEl.offsetWidth;
        numEl.classList.add('flash');
        counter.textContent    = counterName;
        tag.textContent        = ticket.service_type || '';
        tag.style.display      = 'inline-block';
        noMsg.style.display    = 'none';
        numEl.style.display    = 'block';
    } else {
        numEl.style.display    = 'none';
        tag.style.display      = 'none';
        noMsg.style.display    = 'block';
        counter.textContent    = '—';
    }
}

// ─── Counters bar — only repaints if any counter changed ─────────
function renderCountersRow() {
    const hash = JSON.stringify(Object.values(countersData).map(c => ({
        n: c.name, t: c.ticket?.ticket_number ?? null
    })));
    if (hash === lastCountersHash) return; // no change
    lastCountersHash = hash;

    document.getElementById('counters-row').innerHTML =
        Object.values(countersData).map(c => `
            <div class="counter-card">
                <div class="counter-name">${c.name}</div>
                <div class="counter-ticket ${c.ticket ? '' : 'empty'}">
                    ${c.ticket ? c.ticket.ticket_number : 'Idle'}
                </div>
            </div>
        `).join('');
}

// ─── Queue list — only repaints if queue changed ──────────────────
function renderQueue(tickets) {
    const waiting = tickets.filter(t => t.status === 'waiting');
    const hash    = waiting.map(t => t.ticket_number).join(',');
    if (hash === lastQueueHash) return; // no change
    lastQueueHash = hash;

    const list = document.getElementById('queue-list');
    if (!waiting.length) {
        list.innerHTML = '<div class="queue-empty">No one waiting 🎉</div>';
        return;
    }
    list.innerHTML = waiting.map((t, i) => `
        <div class="queue-item">
            <div>
                <div class="queue-badge">${t.ticket_number}</div>
                <div class="queue-meta">${t.service_type?.name ?? ''}</div>
            </div>
            <div class="position-badge ${i === 0 ? 'next' : ''}">${i + 1}</div>
        </div>
    `).join('');
}

// ─── Data fetchers ────────────────────────────────────────────────
async function loadCounters() {
    try {
        const data = await fetch(`${API_BASE}/counters`).then(r => r.json());
        countersData = {};
        let lastServing = null, lastCounter = '—';
        data.forEach(c => {
            countersData[c.id] = { name: c.name, ticket: c.current_ticket };
            if (c.current_ticket) { lastServing = c.current_ticket; lastCounter = c.name; }
        });
        renderCountersRow();
        renderNowServing(lastServing, lastCounter);
    } catch (e) { console.error('Error loading counters:', e); }
}

async function loadQueue() {
    try {
        const data = await fetch(`${API_BASE}/tickets`).then(r => r.json());
        renderQueue(data);
    } catch (e) { console.error('Error loading queue:', e); }
}

async function refreshAll() {
    await Promise.all([loadCounters(), loadQueue()]);
}

// ─── Bootstrap: load immediately, then poll every 3s ─────────────
refreshAll();
setStatus(false, 'Auto-refreshing every 3 seconds...');
setInterval(refreshAll, 3000);

// ─── Reverb (optional — makes changes instant instead of ≤3s) ────
try {
    const echo = new Echo({
        broadcaster: 'reverb',
        key:      REVERB_APP_KEY,
        wsHost:   REVERB_HOST,
        wsPort:   REVERB_PORT,
        wssPort:  REVERB_PORT,
        forceTLS: REVERB_SCHEME === 'https',
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
    });

    echo.connector.pusher.connection.bind('connected', () => {
        setStatus(true, 'Live · Real-time WebSocket connected');
    });
    echo.connector.pusher.connection.bind('disconnected', () => {
        setStatus(false, 'WebSocket disconnected · Auto-refreshing every 3s');
    });

    echo.channel('queue-display').listen('.queue.updated', (e) => {
        if (countersData[e.counter_id]) {
            countersData[e.counter_id].ticket =
                (e.action === 'next' || e.action === 'recall') ? e.ticket : null;
        }
        if (e.action === 'next' || e.action === 'recall') {
            renderNowServing(e.ticket, e.counter_name);
        } else if (e.action === 'skip') {
            renderNowServing(null, '—');
        }
        renderCountersRow();
        loadQueue();
    });
} catch (err) {
    console.warn('Echo unavailable, polling only:', err);
}
</script>
</body>
</html>
