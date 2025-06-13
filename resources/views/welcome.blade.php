<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriView - Track Your Diet, Live Healthier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Optional: Custom gradient for hero section background */
        .hero-bg {
            background: linear-gradient(to bottom, #d4edda, #e2f4ea); /* Light green gradient */
        }
    </style>
</head>
<body class="bg-green-50 font-sans text-gray-800">

<nav class="flex justify-between items-center px-8 py-4 border-b bg-white shadow-sm">
        <div class="text-2xl font-bold text-green-700 flex items-center">
            {{-- Anda bisa menambahkan logo di sini jika ada --}}
            🍏 NutriView
        </div>

        {{-- Ini adalah bagian yang dipindahkan ke tengah --}}
        <div class="hidden md:flex flex-grow justify-center"> {{-- Menambahkan flex-grow dan justify-center --}}
            <div class="space-x-6"> {{-- Ini untuk menjaga jarak antar item --}}
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-green-600 font-semibold">Home</a>
                <a href="#" class="text-gray-700 hover:text-green-600">About</a>
                <a href="#" class="text-gray-700 hover:text-green-600">Contact</a>
            </div>
        </div>

        <div class="space-x-6 hidden md:flex items-center"> {{-- Menambahkan items-center untuk vertikal alignment --}}
            @auth
                <a href="{{ url('/scan') }}" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-4 py-2 rounded">Log In</a>
                <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">Sign Up</a>
            @endauth
        </div>
        <div class="md:hidden">
            <button class="text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <header class="hero-bg text-center py-20 px-6">
        <h1 class="text-5xl md:text-6xl font-extrabold text-green-800 leading-tight mb-4">
            Track Your Diet, <br class="md:hidden">Live Healthier
        </h1>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto mb-8">
            NutriView helps you easily log your meals, understand your nutrition, and achieve your health goals.
        </p>
        <div class="space-x-4">
            @auth
                <a href="{{ url('/scan') }}" class="bg-green-600 text-white text-lg px-8 py-4 rounded-lg font-bold hover:bg-green-700 transition shadow-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="bg-green-600 text-white text-lg px-8 py-4 rounded-lg font-bold hover:bg-green-700 transition shadow-lg">Start Tracking Now</a>
                <a href="{{ route('login') }}" class="bg-white text-green-700 text-lg px-8 py-4 rounded-lg font-bold border border-green-500 hover:bg-green-100 transition shadow-lg">Log In</a>
            @endauth
        </div>
    </header>

    <section class="py-16 px-6 bg-white">
        <h2 class="text-4xl font-bold text-center text-green-800 mb-12">Why Choose NutriView?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="text-center p-6 bg-green-50 rounded-lg shadow-md">
                <div class="text-5xl mb-4">📈</div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Detailed Tracking</h3>
                <p class="text-gray-600">Log every meal and snack with ease to see your daily nutritional intake.</p>
            </div>
            <div class="text-center p-6 bg-green-50 rounded-lg shadow-md">
                <div class="text-5xl mb-4">🍎</div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Personalized Insights</h3>
                <p class="text-gray-600">Get valuable insights into your eating habits and how they affect your health.</p>
            </div>
            <div class="text-center p-6 bg-green-50 rounded-lg shadow-md">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Achieve Goals</h3>
                <p class="text-gray-600">Set and reach your weight, fitness, or dietary goals with clear guidance.</p>
            </div>
        </div>
    </section>

    <section class="bg-green-700 text-white py-16 px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to start your healthier journey?</h2>
        <p class="text-lg mb-8 max-w-xl mx-auto">Join thousands of users who are taking control of their diet with NutriView.</p>
        @auth
            <a href="{{ url('/scan') }}" class="bg-white text-green-700 text-xl px-10 py-4 rounded-lg font-bold hover:bg-green-100 transition shadow-lg">Go to Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="bg-white text-green-700 text-xl px-10 py-4 rounded-lg font-bold hover:bg-green-100 transition shadow-lg">Sign Up Now</a>
        @endauth
    </section>

    <footer class="bg-gray-800 text-white py-8 px-6 text-center">
        <p>&copy; 2025 NutriView. All rights reserved.</p>
        <div class="flex justify-center space-x-6 mt-4 text-gray-400">
            <a href="#" class="hover:text-white">Privacy Policy</a>
            <a href="#" class="hover:text-white">Terms of Service</a>
        </div>
    </footer>

</body>
</html>