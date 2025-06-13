<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NutriView</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 font-sans text-gray-800">

    <nav class="relative flex items-center justify-between px-8 py-4 border-b bg-white shadow-sm">
        <!-- Kiri: Logo -->
        <div class="text-2xl font-bold text-green-700">🍱 NutriView</div>

        <!-- Tengah: Menu -->
        <ul class="absolute left-1/2 transform -translate-x-1/2 flex space-x-6 text-sm font-medium">
            <li><a href="{{ url('/') }}" class="hover:text-green-600">Home</a></li>
            <li><a href="#" class="hover:text-green-600">About</a></li>
            <li><a href="#" class="hover:text-green-600">Contact</a></li>
        </ul>

        <!-- Kanan: Login -->
        <a href="{{ route('register') }}"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition">
            Sign Up
        </a>
    </nav>

    <section class="max-w-xl mx-auto mt-12 text-center px-6">
        {{-- Pastikan file 'fruits.jpg' ada di direktori storage/app/public dan Anda telah menjalankan 'php artisan storage:link' --}}
        <img src="{{ asset('storage/fruits.jpg') }}" alt="Fruits" class="rounded-lg mx-auto mb-6 shadow-md">

        <h1 class="text-2xl font-bold mb-6 text-green-800">Welcome back to NutriView</h1>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <input type="email"
                       name="email"
                       placeholder="Email"
                       required
                       class="w-full p-3 border border-green-200 rounded-lg bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-400"
                       value="{{ old('email') }}"
                       autofocus
                       autocomplete="username">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 text-left">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password"
                       name="password"
                       placeholder="Password"
                       required
                       class="w-full p-3 border border-green-200 rounded-lg bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-400"
                       autocomplete="current-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1 text-left">{{ $message }}</p>
                @enderror
            </div>

            <div class="block text-left">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me"
                           type="checkbox"
                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 underline hover:text-green-600">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit"
                        class="bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition ml-auto">
                    {{ __('Log In') }}
                </button>
            </div>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            Don’t have an account?
            <a href="{{ route('register') }}" class="underline hover:text-green-600">Sign up</a>
        </p>
    </section>

</body>
</html>