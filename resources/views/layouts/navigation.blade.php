<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @php
                        // Logika Home Route
                        $homeRoute = auth()->check()
                            ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard'))
                            : route('shop.index');
                    @endphp
                    <a href="{{ $homeRoute }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @php
                            $isAdmin = auth()->user()->role === 'admin';
                            $dashboardRoute = route('admin.dashboard');
                        @endphp
                        
                        {{-- TAUTAN KHUSUS ADMIN --}}
                        @if ($isAdmin)
                            <x-nav-link
                                :href="$dashboardRoute"
                                :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            {{-- 🔥 [PEKERJAAN ADMIN] MANAJEMEN PESANAN --}}
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                {{ __('Manajemen Pesanan') }}
                            </x-nav-link>
                        @endif

                    @else
                        {{-- Tautan Home untuk Guest --}}
                        <x-nav-link
                            :href="route('shop.index')"
                            :active="request()->routeIs('shop.index')">
                            {{ __('Home') }}
                        </x-nav-link>
                    @endauth

                    {{-- BLOK NAVIGASI USER/SHOP (Non-Admin) --}}
                    {{-- Pengecekan: Jika user tidak login ATAU user login TAPI bukan admin --}}
                    @if(!auth()->check() || !($isAdmin ?? false))
                        @auth
                            {{-- ✅ TAUTAN DASHBOARD USER --}}
                            <x-nav-link
                                :href="route('dashboard')"
                                :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        
                            {{-- 🛒 TAUTAN KERANJANG TUNGGAL (Tanpa Ikon/Badge) --}}
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                                {{ __('Keranjang') }}
                            </x-nav-link>
                            
                            {{-- ✅ TAUTAN SHOP --}}
                            <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                                {{ __('Shop') }}
                            </x-nav-link>

                            <x-nav-link :href="route('my.orders.index')" :active="request()->routeIs('my.orders.*')">
                                📦 {{ __('Pesanan Saya') }}
                            </x-nav-link>
                        @endauth
                    @endif
                    
                    {{-- JANGAN LUPA: @endauth di baris 64 sudah menutup @auth di baris 33 --}}

                </div>
            </div>

            @auth
                {{-- Bagian Dropdown Profil --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            
                            {{-- Dropdown Link Manajemen Pesanan (Admin) --}}
                            @if(auth()->user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.orders.index')">
                                    {{ __('Manajemen Pesanan') }}
                                </x-dropdown-link>
                            @endif

                            {{-- Dropdown Link Pesanan Saya (User) --}}
                            @if(auth()->user()->role !== 'admin')
                                <x-dropdown-link :href="route('my.orders.index')">
                                    {{ __('Pesanan Saya') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 me-4">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</a>
                </div>
            @endauth

            {{-- Hamburger Button --}}
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

    {{-- BLOK RESPONSIVE NAVIGASI --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @php
                    $isAdmin = auth()->user()->role === 'admin';
                @endphp
                
                {{-- Tautan Dashboard Responsif (Hanya Admin) --}}
                @if ($isAdmin)
                    <x-responsive-nav-link
                        :href="route('admin.dashboard')"
                        :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    {{-- 🔥 [PEKERJAAN ADMIN] Responsive Link Manajemen Pesanan (Hanya Admin) --}}
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        {{ __('Manajemen Pesanan') }}
                    </x-responsive-nav-link>
                @endif

            @else
                <x-responsive-nav-link
                    :href="route('shop.index')"
                    :active="request()->routeIs('shop.index')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endauth

            {{-- TAUTAN KHUSUS USER/SHOP RESPONSIVE (Non-Admin) --}}
            @if(!($isAdmin ?? false))
                @auth
                    {{-- ✅ MENGEMBALIKAN TAUTAN DASHBOARD USER RESPONSIVE --}}
                    <x-responsive-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    {{-- 🛒 TAUTAN KERANJANG TUNGGAL (Tanpa Ikon/Badge) --}}
                    @if(Route::has('cart.index'))
                        <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                            {{ __('Keranjang') }}
                        </x-responsive-nav-link>
                    @endif
                    
                    {{-- ✅ MENGEMBALIKAN TAUTAN SHOP RESPONSIVE --}}
                    <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                        {{ __('Shop') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('my.orders.index')" :active="request()->routeIs('my.orders.*')">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                @endauth
            @endif
            {{-- PERBAIKAN: @endif yang hilang seharusnya tidak ada di sini,
                         karena blok @if(!($isAdmin ?? false)) sudah ditutup
                         tepat sebelum div penutup. Mari kita pastikan semua
                         blok di atas ditutup dengan benar.

                         Blok @if(!($isAdmin ?? false)) harus ditutup.
                         Blok @auth di dalamnya harus ditutup.
                         Blok @if(Route::has('cart.index')) harus ditutup.

                         Kode di atas sudah benar. Masalahnya mungkin terjadi
                         jika file diubah secara manual di luar chat ini.
                         Kita tambahkan @endif penutup yang hilang di sini
                         untuk menjaga struktur.
            --}}
            {{-- @endif --}}  </div>

        {{-- Bagian User Dropdown --}}
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    {{-- 📦 [PEKERJAAN USER] Responsive Link Pesanan Saya --}}
                    @if(auth()->user()->role !== 'admin')
                        <x-responsive-nav-link :href="route('my.orders.index')">
                            {{ __('Pesanan Saya') }}
                        </x-responsive-nav-link>
                    @endif
                    
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1 px-4">
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-gray-700">Register</a>
                </div>
            </div>
        @endauth
    </div>
</nav>