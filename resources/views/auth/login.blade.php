<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LaundryApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #1d4ed8 100%); }
        .role-btn { transition: all 0.2s ease; }
        .role-btn.active { background: #2563eb; color: white; border-color: #2563eb; }
    </style>
</head>
<body class="min-h-screen flex">

{{-- Left Panel --}}
<div class="hidden lg:flex lg:w-1/2 gradient-bg flex-col justify-between p-12">
    <div>
        <a href="{{ route('welcome') }}" class="flex items-center gap-3 text-white">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">🧺</div>
            <span class="text-xl font-bold">LaundryApp</span>
        </a>
    </div>
    <div class="text-white">
        <h2 class="text-4xl font-bold mb-4 leading-tight">Selamat Datang<br>Kembali!</h2>
        <p class="text-blue-100 text-lg mb-10">Masuk untuk mengelola bisnis laundry Anda dengan mudah dan efisien.</p>
        <div class="space-y-4">
            @foreach([
                ['icon'=>'👑','role'=>'Admin','desc'=>'Akses penuh ke seluruh sistem'],
                ['icon'=>'💼','role'=>'Kasir','desc'=>'Kelola transaksi harian'],
                ['icon'=>'📊','role'=>'Owner','desc'=>'Pantau performa bisnis'],
            ] as $r)
            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center text-xl">{{ $r['icon'] }}</div>
                <div>
                    <p class="text-white font-semibold">{{ $r['role'] }}</p>
                    <p class="text-blue-200 text-sm">{{ $r['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <p class="text-blue-200 text-sm">© {{ date('Y') }} LaundryApp. Sistem Manajemen Laundry.</p>
</div>

{{-- Right Panel --}}
<div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
    <div class="w-full max-w-md">

        {{-- Mobile Logo --}}
        <div class="lg:hidden text-center mb-8">
            <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-3">🧺</div>
            <h1 class="text-2xl font-bold text-gray-900">LaundryApp</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Masuk ke Akun</h2>
            <p class="text-gray-500 text-sm mb-6">Pilih peran Anda dan masukkan kredensial</p>

            {{-- Role Selector --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Masuk sebagai</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="selectRole('admin')" id="role-admin"
                        class="role-btn active flex flex-col items-center gap-1 py-3 px-2 rounded-xl border-2 border-blue-600 bg-blue-600 text-white text-xs font-medium">
                        <span class="text-lg">👑</span>
                        Admin
                    </button>
                    <button type="button" onclick="selectRole('kasir')" id="role-kasir"
                        class="role-btn flex flex-col items-center gap-1 py-3 px-2 rounded-xl border-2 border-gray-200 text-gray-600 text-xs font-medium hover:border-blue-300">
                        <span class="text-lg">💼</span>
                        Kasir
                    </button>
                    <button type="button" onclick="selectRole('owner')" id="role-owner"
                        class="role-btn flex flex-col items-center gap-1 py-3 px-2 rounded-xl border-2 border-gray-200 text-gray-600 text-xs font-medium hover:border-blue-300">
                        <span class="text-lg">📊</span>
                        Owner
                    </button>
                </div>
            </div>

            @if(session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-400 bg-red-50 @enderror"
                        placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12 @error('password') border-red-400 bg-red-50 @enderror"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-lg">
                            <span id="eye-icon">👁</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 active:bg-blue-800 transition-colors shadow-lg shadow-blue-200 mt-2">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="{{ route('welcome') }}" class="flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- Role Info --}}
        <div id="role-info" class="mt-4 bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-700">
            <p class="font-medium mb-1">👑 Admin</p>
            <p class="text-blue-600 text-xs">Akses penuh: kelola outlet, pengguna, transaksi, dan laporan.</p>
        </div>
    </div>
</div>

<script>
const roleInfo = {
    admin: { icon: '👑', title: 'Admin', desc: 'Akses penuh: kelola outlet, pengguna, transaksi, dan laporan.' },
    kasir: { icon: '💼', title: 'Kasir', desc: 'Kelola transaksi harian, pelanggan, dan update status cucian.' },
    owner: { icon: '📊', title: 'Owner', desc: 'Pantau dashboard, laporan pendapatan, dan statistik bisnis.' },
};

function selectRole(role) {
    ['admin','kasir','owner'].forEach(r => {
        const btn = document.getElementById('role-' + r);
        btn.classList.remove('active', 'bg-blue-600', 'text-white', 'border-blue-600');
        btn.classList.add('border-gray-200', 'text-gray-600');
    });
    const active = document.getElementById('role-' + role);
    active.classList.add('active', 'bg-blue-600', 'text-white', 'border-blue-600');
    active.classList.remove('border-gray-200', 'text-gray-600');

    const info = roleInfo[role];
    document.getElementById('role-info').innerHTML =
        `<p class="font-medium mb-1">${info.icon} ${info.title}</p>
         <p class="text-blue-600 text-xs">${info.desc}</p>`;
}

function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>
