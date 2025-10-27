@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }} · Admin</title>

  {{-- Tailwind via CDN (stabil, no Vite) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50:  '#eef6ff',
              100: '#d9ebff',
              200: '#b6d9ff',
              300: '#8cc1ff',
              400: '#59a4ff',
              500: '#2f83ff',  /* utama */
              600: '#2266db',
              700: '#1c51b0',
              800: '#1a468f',
              900: '#183e78',
            }
          },
          boxShadow: {
            soft: '0 1px 2px rgba(16,24,40,.06), 0 1px 3px rgba(16,24,40,.1)'
          }
        }
      },
      darkMode: 'class'
    }
  </script>

  {{-- Icon --}}
  <link href="https://unpkg.com/lucide-static@0.441.0/font/lucide.css" rel="stylesheet">
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen">
    {{-- SIDEBAR --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-white/90 backdrop-blur border-r z-40 hidden md:flex md:flex-col">
      <div class="h-16 px-5 flex items-center gap-3 border-b">
        <div class="h-9 w-9 rounded-xl bg-brand-500/10 text-brand-600 grid place-items-center">
          <i class="lucide-bar-chart-3"></i>
        </div>
        <div>
          <div class="font-semibold">Admin Panel</div>
          <div class="text-xs text-slate-500">eCommerce</div>
        </div>
      </div>

      <nav class="p-3 space-y-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700 border border-brand-100' : 'hover:bg-slate-50' }}">
          <i class="lucide-layout-dashboard text-[18px]"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
          <i class="lucide-box text-[18px]"></i>
          <span>Produk</span>
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
          <i class="lucide-shapes text-[18px]"></i>
          <span>Kategori</span>
        </a>
        <a href="{{ route('orders.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
          <i class="lucide-shopping-bag text-[18px]"></i>
          <span>Pesanan</span>
        </a>
        <a href="{{ route('shop.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
          <i class="lucide-store text-[18px]"></i>
          <span>Katalog</span>
        </a>
      </nav>

      <div class="mt-auto p-3 border-t">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-md bg-slate-900 text-white hover:bg-slate-800">
            <i class="lucide-log-out text-[18px]"></i> Keluar
          </button>
        </form>
      </div>
    </aside>

    {{-- TOPBAR (mobile) --}}
    <header class="md:hidden sticky top-0 z-40 bg-white/90 backdrop-blur border-b">
      <div class="h-14 px-4 flex items-center justify-between">
        <button onclick="document.getElementById('mobile-drawer').classList.remove('hidden')"
                class="p-2 rounded-md border hover:bg-slate-50">
          <i class="lucide-menu"></i>
        </button>
        <div class="font-semibold">{{ $title }}</div>
        <div class="h-8 w-8 grid place-items-center rounded-md bg-brand-50 text-brand-700">
          <i class="lucide-bar-chart-3 text-[18px]"></i>
        </div>
      </div>
    </header>

    {{-- DRAWER mobile --}}
    <div id="mobile-drawer" class="fixed inset-0 z-50 hidden">
      <div class="absolute inset-0 bg-black/30" onclick="this.parentElement.classList.add('hidden')"></div>
      <div class="absolute inset-y-0 left-0 w-72 bg-white shadow-xl">
        <div class="h-14 flex items-center justify-between px-4 border-b">
          <div class="font-semibold">Menu</div>
          <button class="p-2 rounded-md hover:bg-slate-50" onclick="document.getElementById('mobile-drawer').classList.add('hidden')">
            <i class="lucide-x"></i>
          </button>
        </div>
        <div class="p-3 space-y-1">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
            <i class="lucide-layout-dashboard text-[18px]"></i> Dashboard
          </a>
          <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50">
            <i class="lucide-box text-[18px]"></i> Produk
          </a>
          <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px
