<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Queueing System')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #060d18;
            --surface:   #0d1829;
            --surface-2: #112036;
            --border:    #1a2d45;
            --border-hi: rgba(56, 189, 248, 0.25);
            --accent:    #38bdf8;
            --accent-dk: #0ea5e9;
            --accent-dkr:#0284c7;
            --text:      #e2eaf4;
            --text-2:    #7a9ab8;
            --text-3:    #3a5068;
            --green:     #34d399;
            --green-bg:  rgba(52, 211, 153, 0.1);
            --green-border: rgba(52, 211, 153, 0.25);
            --radius-sm: 10px;
            --radius:    16px;
            --radius-lg: 24px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            /* subtle noise-like dot grid */
            background-image: radial-gradient(circle, rgba(56,189,248,0.03) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ── Header ── */
        header {
            text-align: center;
            padding: 2.5rem 0 2rem;
            margin-bottom: 2.5rem;
            position: relative;
        }

        header::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 480px;
            max-width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-hi) 30%, var(--border-hi) 70%, transparent);
        }

        .header-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 0.75rem;
            opacity: 0.8;
        }

        header h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.02em;
            line-height: 1.15;
        }

        header h1 span { color: var(--accent); }

        header p {
            color: var(--text-2);
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        @yield('styles')
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-eyebrow">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 9h6M9 12h6M9 15h4"/></svg>
                Office Services
            </div>
            <h1>🏢 <span>Office</span> Queueing System</h1>
            <p>@yield('subtitle', 'Organized. Fast. Efficient.')</p>
        </header>

        @yield('content')
    </div>
</body>
</html>