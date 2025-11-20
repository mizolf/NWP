<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Bootstrap 5 CSS (CDN) -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary-color: #2563eb;
                --primary-hover: #1d4ed8;
                --secondary-color: #64748b;
                --success-color: #10b981;
                --danger-color: #ef4444;
                --bg-main: #f8fafc;
                --bg-card: #ffffff;
                --text-primary: #0f172a;
                --text-secondary: #475569;
                --border-color: #e2e8f0;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-main);
                color: var(--text-primary);
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Poppins', sans-serif;
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                font-weight: 500;
                padding: 0.625rem 1.25rem;
                border-radius: 0.5rem;
                transition: all 0.2s;
            }

            .btn-primary:hover {
                background-color: var(--primary-hover);
                border-color: var(--primary-hover);
                transform: translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .btn-outline-primary {
                color: var(--primary-color);
                border-color: var(--primary-color);
                font-weight: 500;
                border-radius: 0.5rem;
                transition: all 0.2s;
            }

            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                transform: translateY(-1px);
            }

            .btn-outline-secondary {
                color: var(--secondary-color);
                border-color: var(--border-color);
                font-weight: 500;
                border-radius: 0.5rem;
                transition: all 0.2s;
            }

            .btn-outline-secondary:hover {
                background-color: var(--bg-main);
                border-color: var(--secondary-color);
            }

            .card {
                border: 1px solid var(--border-color);
                border-radius: 0.75rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                transition: all 0.2s;
            }

            .card:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .table {
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .table thead {
                background-color: var(--bg-main);
                border-bottom: 2px solid var(--border-color);
            }

            .table th {
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.05em;
                color: var(--text-secondary);
                padding: 0.875rem 1rem;
            }

            .table td {
                padding: 0.875rem 1rem;
                vertical-align: middle;
            }

            .table-hover tbody tr:hover {
                background-color: #f1f5f9;
            }

            .form-control, .form-select {
                border-color: var(--border-color);
                border-radius: 0.5rem;
                padding: 0.625rem 0.875rem;
                transition: all 0.2s;
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }

            .alert {
                border-radius: 0.5rem;
                border: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" style="background-color: var(--bg-main)">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
