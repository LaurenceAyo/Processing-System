<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $counter->name }} — Staff Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #050d1a;
            --surface:  #0d1f35;
            --border:   #1a3a5c;
            --accent:   #00d4ff;
            --text:     #e2f0ff;
            --muted:    #4a7fa5;
            --green:    #22c55e;
            --amber:    #f59e0b;
            --red:      #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top Bar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 2rem;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .topbar .left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.2s;
        }
        .back-btn:hover { color: var(--text); }

        .counter-badge {
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: var(--accent);
            padding: 0.3rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .clock-mini {
            font-size: 1rem;
            font-weight: 600;
            color: var(--muted);
            font-variant-numeric: tabular-nums;
        }

        /* ── Main Layout ── */
        .main {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 0;
        }

        /* ── Serving Panel (left) ── */
        .serving-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border-right: 1px solid var(--border);
            gap: 1.5rem;
        }

        .now-serving-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .ticket-display {
            text-align: center;
        }

        .big-ticket {
            font-size: clamp(4rem, 10vw, 8rem);
            font-weight: 900;
            line-height: 1;
            color: #fff;
            letter-spacing: -0.02em;
            text-shadow: 0 0 40px rgba(0, 212, 255, 0.3);
        }

        .big-ticket.animate {
            animation: pop-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes pop-in {
            0%  { transform: scale(0.8); opacity: 0.3; }
            100%{ transform: scale(1);   opacity: 1; }
        }

        .ticket-service {
            margin-top: 0.6rem;
            display: inline-block;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.25);
            color: var(--accent);
            padding: 0.25rem 0.9rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .idle-msg {
            font-size: 1.1rem;
            color: var(--muted);
            font-weight: 300;
        }

        /* ── Action Buttons ── */
        .actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: transform 0.15s, opacity 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.02em;
        }
        .btn:hover   { transform: translateY(-2px); }
        .btn:active  { transform: scale(0.97); }
        .btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

        .btn-next   { background: var(--green); color: #fff; box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3); }
        .btn-recall { background: var(--amber); color: #000; box-shadow: 0 4px 20px rgba(245, 158, 11, 0.25); }
        .btn-skip   { background: #1e293b; border: 1px solid var(--border); color: var(--red); box-shadow: none; }

        /* ── Queue Counter ── */
        .queue-counter {
            font-size: 0.85rem;
            color: var(--muted);
        }
        .queue-counter span {
            color: var(--text);
            font-weight: 700;
        }

        /* ── Toast Notification ── */
        .toast {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #1e293b;
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: transform 0.3s ease;
            z-index: 100;
            white-space: nowrap;
            box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        }
        .toast.show { transform: translateX(-50%) translateY(0); }
        .toast.green { border-color: var(--green); color: var(--green); }
        .toast.amber { border-color: var(--amber); color: var(--amber); }
        .toast.red   { border-color: var(--red);   color: var(--red); }

        /* ── Right sidebar: Queue List ── */
        .queue-sidebar {
            display: flex;
            flex-direction: column;
            background: var(--surface);
        }

        .sidebar-header {
            padding: 1rem 1.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .waiting-count {
            background: var(--border);
            color: var(--text);
            border-radius: 999px;
            padding: 0.1rem 0.6rem;
            font-size: 0.72rem;
        }

        .queue-list {
            flex: 1;
            overflow-y: auto;
        }

        .queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1.5rem;
            border-bottom: 1px solid rgba(26, 58, 92, 0.4);
        }

        .queue-item:first-child {
            background: rgba(34, 197, 94, 0.05);
            border-left: 3px solid var(--green);
        }

        .q-number { font-size: 1.1rem; font-weight: 700; color: var(--text); }
        .q-service { font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }

        .q-pos {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--border);
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .q-pos.next-badge { background: rgba(34, 197, 94, 0.2); color: var(--green); }

        .queue-empty {
            text-align: center;
            padding: 2.5rem 1.5rem;
            color: var(--muted);
            font-size: 0.85rem;
        }

        /* ── Service-type filter buttons ── */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .filter-btn {
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn.active, .filter-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: var(--accent);
            color: var(--accent);
        }

        .queue-list::-webkit-scrollbar { width: 4px; }
        .queue-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="left">
        <a href="/staff" class="back-btn">← Change Counter</a>
        <span class="counter-badge">{{ $counter->name }}</span>
    </div>
    <div class="clock-mini" id="clock">--:--</div>
</div>

<div class="main">

    <!-- Serving Panel -->
    <div class="serving-panel">
        <div class="now-serving-label">Now Serving</div>

        <div class="ticket-display" id="ticket-display">
            @if($currentTicket)
                <div class="big-ticket" id="big-ticket">{{ $currentTicket->ticket_number }}</div>
                <div class="ticket-service" id="ticket-service">{{ $currentTicket->serviceType?->name }}</div>
            @else
                <div class="idle-msg" id="idle-msg">No ticket being served</div>
                <div class="big-ticket" id="big-ticket" style="display:none"></div>
                <div class="ticket-service" id="ticket-service" style="display:none"></div>
            @endif
        </div>

        <div class="actions">
            <button class="btn btn-next"   id="btn-next"   onclick="doAction('next')">
                ▶ Next
            </button>
            <button class="btn btn-recall" id="btn-recall" onclick="doAction('recall')"
                {{ $currentTicket ? '' : 'disabled' }}>
                🔁 Recall
            </button>
            <button class="btn btn-skip"   id="btn-skip"   onclick="doAction('skip')"
                {{ $currentTicket ? '' : 'disabled' }}>
                ⏭ Skip
            </button>
        </div>

        <div class="queue-counter">
            Waiting: <span id="waiting-count">...</span> tickets
        </div>
    </div>

    <!-- Queue Sidebar -->
    <div class="queue-sidebar">
        <div class="sidebar-header">
            <span>Waiting Queue</span>
            <span class="waiting-count" id="waiting-badge">—</span>
        </div>

        <div class="filter-bar" id="filter-bar">
            <button class="filter-btn active" onclick="filterQueue(null, this)">All</button>
            @foreach($serviceTypes as $svc)
                <button class="filter-btn" onclick="filterQueue({{ $svc->id }}, this)">
                    {{ $svc->code }}
                </button>
            @endforeach
        </div>

        <div class="queue-list" id="queue-list">
            <div class="queue-empty">Loading...</div>
        </div>
    </div>

</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<script>
const COUNTER_ID = {{ $counter->id }};
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

let allTickets = [];
let activeFilter = null;

// ─── Clock ───────────────────────────────────────────────────────
setInterval(() => {
    document.getElementById('clock').textContent =
        new Date().toLocaleTimeString('en-PH', { hour12: true, hour: '2-digit', minute: '2-digit' });
}, 1000);

// ─── Toast ───────────────────────────────────────────────────────
function showToast(msg, type = '') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className   = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3000);
}

// ─── Ticket display ───────────────────────────────────────────────
function setCurrentTicket(ticket) {
    const big     = document.getElementById('big-ticket');
    const svcTag  = document.getElementById('ticket-service');
    const idleMsg = document.getElementById('idle-msg');
    const btnRecall = document.getElementById('btn-recall');
    const btnSkip   = document.getElementById('btn-skip');

    if (ticket) {
        big.textContent   = ticket.ticket_number;
        svcTag.textContent = ticket.service_type ?? '';
        big.style.display    = 'block';
        svcTag.style.display = 'inline-block';
        if (idleMsg) idleMsg.style.display = 'none';
        big.classList.remove('animate');
        void big.offsetWidth;
        big.classList.add('animate');
        btnRecall.disabled = false;
        btnSkip.disabled   = false;
    } else {
        big.style.display    = 'none';
        svcTag.style.display = 'none';
        if (idleMsg) idleMsg.style.display = 'block';
        btnRecall.disabled = true;
        btnSkip.disabled   = true;
    }
}

// ─── Queue list rendering ─────────────────────────────────────────
function filterQueue(serviceTypeId, el) {
    activeFilter = serviceTypeId;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    renderQueueList();
}

function renderQueueList() {
    const list    = document.getElementById('queue-list');
    const waiting = allTickets.filter(t =>
        t.status === 'waiting' &&
        (activeFilter === null || t.service_type_id === activeFilter)
    );
    const total = allTickets.filter(t => t.status === 'waiting').length;

    document.getElementById('waiting-count').textContent = total;
    document.getElementById('waiting-badge').textContent  = total;

    if (!waiting.length) {
        list.innerHTML = '<div class="queue-empty">No waiting tickets 🎉</div>';
        return;
    }

    list.innerHTML = waiting.map((t, i) => `
        <div class="queue-item">
            <div>
                <div class="q-number">${t.ticket_number}</div>
                <div class="q-service">${t.service_type?.name ?? ''}</div>
            </div>
            <div class="q-pos ${i === 0 ? 'next-badge' : ''}">${i + 1}</div>
        </div>
    `).join('');
}

// ─── Load queue ───────────────────────────────────────────────────
async function loadQueue() {
    const res  = await fetch('/api/tickets');
    allTickets = await res.json();
    renderQueueList();
}

// ─── Actions ─────────────────────────────────────────────────────
async function doAction(action) {
    const btn = document.getElementById(`btn-${action}`);
    btn.disabled = true;

    try {
        const res  = await fetch(`/api/counters/${COUNTER_ID}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'X-CSRF-Token':  CSRF_TOKEN,
                'Accept':        'application/json',
            },
        });
        const data = await res.json();

        if (!res.ok) {
            showToast(data.message || 'Error', 'red');
            return;
        }

        const labels = { next: '✅ Next!', recall: '🔁 Recalled!', skip: '⏭ Skipped' };
        const types  = { next: 'green',    recall: 'amber',        skip: 'red' };
        showToast(labels[action] + (data.ticket ? ' — ' + data.ticket.ticket_number : ''), types[action]);

        setCurrentTicket(data.ticket ?? null);
        await loadQueue();

    } catch (e) {
        showToast('Network error', 'red');
    } finally {
        btn.disabled = false;
    }
}

// ─── CSRF for API POSTs ───────────────────────────────────────────
// The api routes are stateless but our app uses web session CSRF.
// We send X-CSRF-Token header for the web middleware stack.

// ─── Bootstrap ───────────────────────────────────────────────────
loadQueue();
setInterval(loadQueue, 8000); // soft refresh every 8s as fallback
</script>

</body>
</html>
