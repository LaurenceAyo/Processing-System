<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Queueing System')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: #f1f5f9;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            text-align: center;
            padding: 2rem 0 1rem;
            border-bottom: 1px solid #1e293b;
            margin-bottom: 2rem;
        }

        header h1 {
            font-size: 1.6rem;
            color: #38bdf8;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        header p {
            color: #64748b;
            margin-top: 0.3rem;
            font-size: 0.9rem;
        }

        @yield('styles')
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🏢 Office Queueing System</h1>
            <p>@yield('subtitle', 'Organized. Fast. Efficient.')</p>
        </header>

        @yield('content')
    </div>
</body>
</html>
