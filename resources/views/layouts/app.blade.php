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

               <nav class="flex justify-between items-center px-8 py-4 border-b bg-white shadow-sm">
            {{-- Logo NutriView --}}
            <div class="text-2xl font-bold text-green-700">🍏 NutriView</div>

            {{-- Navigation Links (Tengah) --}}
            <div class="flex flex-grow justify-center space-x-9 text-sm font-medium">
                {{-- <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-green-600">Dashboard</a> --}}
                <a href="{{ url('/scan') }}" class="text-gray-700 hover:text-green-600">Scan</a>
                <a href="{{ url('/chat') }}" class="text-gray-700 hover:text-green-600">Chat</a>
                <a href="{{ url('/chat') }}" class="text-gray-700 hover:text-green-600">History</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-green-600"> {{-- Tambahkan kelas teks untuk hover --}}
            
                        <span class="font-medium hidden md:inline">{{ Auth::user()->name }}</span> {{-- Tampilkan nama di samping avatar --}}
                    </a>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    {{-- Jika tidak login, tampilkan tombol login/register --}}
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-4 py-2 rounded">Log In</a>
                    <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">Sign Up</a>
                @endauth
            </div>
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
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</body>

</html>
