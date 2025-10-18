<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @php
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
                            $dashboardRoute = auth()->user()->role === 'admin'
                                ? route('admin.dashboard')
                                : route('dashboard');
                        @endphp
                        
                        {{-- Tautan Dashboard --}}
                        <x-nav-link
                            :href="$dashboardRoute"
                            :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        {{-- 🔥 [PEKERJAAN ADMIN] MANAJEMEN PESANAN (Hanya Admin) --}}
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                {{ __('Manajemen Pesanan') }}
                            </x-nav-link>
                        @endif

                        {{-- 🛒 [PEKERJAAN SHOP] KERANJANG (Cart) --}}
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                            {{ __('Keranjang') }}
                        </x-nav-link>

                    @else
                        <x-nav-link
                            :href="route('shop.index')"
                            :active="request()->routeIs('shop.index')">
                            {{ __('Home') }}
                        </x-nav-link>
                    @endauth

                    @php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

{{-- Tampilkan menu khusus user non-admin --}}
@if(!$isAdmin)
    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
        {{ __('Shop') }}
    </x-nav-link>

    @if(Route::has('cart.index'))
        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
            🛒 {{ __('Keranjang') }}
            @php
                $cartCount = session('cart') ? collect(session('cart'))->sum('qty') : 0;
            @endphp
            @if($cartCount > 0)
                <span class="ml-1 bg-emerald-500 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ $cartCount }}
                </span>
            @endif
        </x-nav-link>
    @endif

    @auth
        <x-nav-link :href="route('my.orders.index')" :active="request()->routeIs('my.orders.*')">
            📦 {{ __('Pesanan Saya') }}
        </x-nav-link>
    @endauth
@endif

                </div>
            </div>

            @auth
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
                            
                            {{-- 🔥 [PEKERJAAN ADMIN] Dropdown Link untuk Manajemen Pesanan (Hanya Admin) --}}
                            @if(auth()->user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.orders.index')">
                                    {{ __('Manajemen Pesanan') }}
                                </x-dropdown-link>
                            @endif

                            {{-- 📦 [PEKERJAAN USER] Dropdown Link untuk Pesanan Saya (My Orders) --}}
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
            @auth
                {{-- Tautan Dashboard Responsif --}}
                <x-responsive-nav-link
                    :href="auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')"
                    :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                {{-- 🔥 [PEKERJAAN ADMIN] Responsive Link Manajemen Pesanan (Hanya Admin) --}}
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        {{ __('Manajemen Pesanan') }}
                    </x-responsive-nav-link>
                @endif

                {{-- 🛒 [PEKERJAAN SHOP] Responsive Link Keranjang (Cart) --}}
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Keranjang') }}
                </x-responsive-nav-link>

            @else
                <x-responsive-nav-link
                    :href="route('shop.index')"
                    :active="request()->routeIs('shop.index')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endauth

            @php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if(!$isAdmin)
    <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
        {{ __('Shop') }}
    </x-responsive-nav-link>

    @if(Route::has('cart.index'))
        <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
            {{ __('Keranjang') }}
            @php
                $cartCount = session('cart') ? collect(session('cart'))->sum('qty') : 0;
            @endphp
            @if($cartCount > 0)
                <span class="ml-2 inline-block bg-emerald-500 text-white text-xs px-2 py-0.5 rounded-full align-middle">
                    {{ $cartCount }}
                </span>
            @endif
        </x-responsive-nav-link>
    @endif

    @auth
        <x-responsive-nav-link :href="route('my.orders.index')" :active="request()->routeIs('my.orders.*')">
            {{ __('Pesanan Saya') }}
        </x-responsive-nav-link>
    @endauth
@endif

        </div>

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