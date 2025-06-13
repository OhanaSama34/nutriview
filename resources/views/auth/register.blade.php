<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NutriView</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 text-gray-800">

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
        <a href="{{ route('login') }}"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition">
            Log In
        </a>
    </nav>



    <div class="flex flex-col items-center justify-center mt-10 px-4">
        <h1 class="text-2xl md:text-3xl font-bold mb-8 text-green-800">Create your account</h1>

        <form method="POST" action="{{ route('register') }}"
            class="w-full max-w-md space-y-4 bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div>
                <label for="name" class="block mb-1 font-semibold text-green-700">Full Name</label>
                <input id="name" type="text" name="name" placeholder="Enter your full name"
                    value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full px-4 py-2 bg-green-100 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block mb-1 font-semibold text-green-700">Email</label>
                <input id="email" type="email" name="email" placeholder="Enter your email"
                    value="{{ old('email') }}" required autocomplete="username"
                    class="w-full px-4 py-2 bg-green-100 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-1 font-semibold text-green-700">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required
                    autocomplete="new-password"
                    class="w-full px-4 py-2 bg-green-100 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 font-semibold text-green-700">Confirm
                    Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Confirm your password" required autocomplete="new-password"
                    class="w-full px-4 py-2 bg-green-100 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition">
                Sign Up
            </button>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="underline hover:text-green-600">Log in</a>
        </p>
    </div>

</body>

</html>
