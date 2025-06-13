<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm px-8 py-4"> {{-- Tambahkan padding dan shadow --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center"> {{-- Tambahkan items-center --}}
            <div class="flex items-center"> {{-- Tambahkan items-center --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        {{-- Mengganti x-application-logo dengan teks NutriView --}}
                        <div class="text-2xl font-bold text-green-700">🍏 NutriView</div>
                        {{-- Jika Anda ingin menggunakan logo gambar, bisa pakai ini: --}}
                        {{-- <img src="{{ asset('path/to/your/nutriview-logo.png') }}" alt="NutriView Logo" class="h-9 w-auto"> --}}
                    </a>
                </div>

                {{-- Memastikan navigasi link berada di tengah dengan flex-grow dan justify-center --}}
                <div class="hidden sm:flex sm:items-center sm:ms-10 flex-grow justify-center">
                    <ul class="flex space-x-6 text-sm font-medium">
                        <li>
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-700 hover:text-green-600">
                                {{ __('Dashboard') }} {{-- Ini akan jadi Home di sisi pengguna --}}
                            </x-nav-link>
                        </li>
                        <li><a href="#" class="text-gray-700 hover:text-green-600">Features</a></li>
                        <li><a href="#" class="text-gray-700 hover:text-green-600">About Us</a></li>
                        <li><a href="#" class="text-gray-700 hover:text-green-600">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4"> {{-- Tambahkan space-x-4 untuk jarak --}}
                {{-- Icon Bell / Notifications (Opsional, jika Anda ingin menambahkan) --}}
                {{-- Jika Anda ingin tombol SVG notifikasi seperti di contoh gambar--}}
                {{-- <button class="p-2 rounded-full bg-green-100 hover:bg-green-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button> --}}

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        {{-- Tampilan Trigger Dropdown Sesuai Gaya NutriView --}}
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            {{-- Ganti Auth::user()->name dengan avatar gambar --}}
                            <img src="{{ asset('images/avatar.png') }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover mr-2 border border-green-300"> {{-- Pastikan path gambar ini benar --}}
                            <div class="hidden md:block">{{ Auth::user()->name }}</div> {{-- Tampilkan nama user di layar besar --}}
                            <div class="ms-1 hidden md:block"> {{-- Icon dropdown hanya muncul di layar besar --}}
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- Tambahkan responsive nav link untuk Features, About Us, Contact --}}
            <x-responsive-nav-link :href="'#'">Features</x-responsive-nav-link>
            <x-responsive-nav-link :href="'#'">About Us</x-responsive-nav-link>
            <x-responsive-nav-link :href="'#'">Contact</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>