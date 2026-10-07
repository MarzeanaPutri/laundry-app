<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LaundryApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.15s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); }
        .sidebar-link.active { background: rgba(255,255,255,0.15); border-left: 3px solid #93c5fd; }
        .sidebar-link:not(.active) { border-left: 3px solid transparent; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 flex-shrink-0 flex flex-col" style="background: linear-gradient(180deg, #1e3a5f 0%, #1e40af 100%);">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-lg">🧺</div>
                <div>
                    <h1 class="text-white font-bold text-base leading-tight">LaundryApp</h1>
                    <p class="text-blue-300 text-xs">Sistem Manajemen</p>
                </div>
            </div>
        </div>

        {{-- User Info --}}
        <div class="px-5 py-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-400/30 rounded-xl flex items-center justify-center text-sm font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        @if(auth()->user()->role === 'admin') bg-red-400/20 text-red-200
                        @elseif(auth()->user()->role === 'kasir') bg-blue-400/20 text-blue-200
                        @else bg-green-400/20 text-green-200 @endif">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">📊</span>
                <span>Dashboard</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isKasir())
            <div class="pt-4 pb-1 px-3">
                <p class="text-blue-400 text-xs font-semibold uppercase tracking-wider">Operasional</p>
            </div>
            <a href="{{ route('customers.index') }}"
                class="sidebar-link {{ request()->routeIs('customers.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">👥</span>
                <span>Pelanggan</span>
            </a>
            <a href="{{ route('transactions.index') }}"
                class="sidebar-link {{ request()->routeIs('transactions.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">🧾</span>
                <span>Transaksi</span>
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="pt-4 pb-1 px-3">
                <p class="text-blue-400 text-xs font-semibold uppercase tracking-wider">Administrasi</p>
            </div>
            <a href="{{ route('outlets.index') }}"
                class="sidebar-link {{ request()->routeIs('outlets.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">🏪</span>
                <span>Outlet</span>
            </a>
            <a href="{{ route('products.index') }}"
                class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">📦</span>
                <span>Paket Laundry</span>
            </a>
            <a href="{{ route('users.index') }}"
                class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">👤</span>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('logs.index') }}"
                class="sidebar-link {{ request()->routeIs('logs.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">📋</span>
                <span>System Log</span>
            </a>
            @endif

            <div class="pt-4 pb-1 px-3">
                <p class="text-blue-400 text-xs font-semibold uppercase tracking-wider">Laporan</p>
            </div>
            <a href="{{ route('reports.index') }}"
                class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-100 hover:text-white">
                <span class="text-base w-5 text-center">📈</span>
                <span>Laporan</span>
            </a>
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-blue-200 hover:text-white hover:bg-white/10 transition-all">
                    <span class="text-base w-5 text-center">🚪</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Header --}}
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">@yield('header', 'Dashboard')</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if(auth()->user()->outlet)
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">
                    🏪 {{ auth()->user()->outlet->name }}
                </span>
                @endif
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <span>❌</span> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
