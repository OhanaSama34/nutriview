<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Aplikasi Rekomendasi Gizi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen bg-gray-100">
        
        <!-- Navbar -->
        <nav class="p-4 bg-white shadow">
            <a href="/dashboard" class="mr-4 hover:underline">Dashboard</a>
            <a href="/scan" class="mr-4 hover:underline">scan</a>
            <a href="/chat" class="mr-4 hover:underline">Chat</a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Logout</button>
            </form>
        </nav>

        <!-- Optional header -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main content -->
        <<main class="p-6">
         @yield('content')
        </main>

    </div>
</body>
</html>
