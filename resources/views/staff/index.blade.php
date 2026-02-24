<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login — Office Queueing System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #050d1a;
            color: #e2f0ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .logo {
            font-size: 1rem;
            font-weight: 700;
            color: #00d4ff;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.4rem;
        }
        .subtitle {
            color: #4a7fa5;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.2rem;
            width: 100%;
            max-width: 680px;
        }
        .counter-btn {
            background: #0d1f35;
            border: 1px solid #1a3a5c;
            border-radius: 16px;
            padding: 1.8rem 1.2rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .counter-btn:hover {
            transform: translateY(-4px);
            border-color: #00d4ff;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.15);
        }
        .counter-icon {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }
        .counter-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #e2f0ff;
        }
        .counter-label {
            font-size: 0.78rem;
            color: #4a7fa5;
            margin-top: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="logo">🏢 Office Queueing System</div>
    <h1>Staff Portal</h1>
    <p class="subtitle">Select your counter to begin</p>

    <div class="grid">
        @foreach($counters as $counter)
            <a href="{{ url('/staff/' . $counter->id) }}" class="counter-btn">
                <div class="counter-icon">🖥️</div>
                <div class="counter-name">{{ $counter->name }}</div>
                <div class="counter-label">Click to open panel</div>
            </a>
        @endforeach
    </div>
</body>
</html>
