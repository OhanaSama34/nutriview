<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Notifikasi Error --}}
                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 text-red-600 p-2 mb-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ __("You're logged in!") }}

                    <h1 class="text-xl font-bold">Selamat datang, {{ auth()->user()->name }}</h1>
                    <p>Role: {{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
