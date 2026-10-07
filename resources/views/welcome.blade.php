<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry App - Sistem Manajemen Laundry Modern</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #1d4ed8 100%); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .float-animation { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    </style>
</head>
<body class="bg-gray-50">

{{-- Navbar --}}
<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white text-lg">🧺</div>
            <span class="text-xl font-bold text-gray-900">LaundryApp</span>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors">
                    Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-100 transition-colors">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="gradient-bg min-h-screen flex items-center pt-20">
    <div class="max-w-6xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-16 items-center">
        <div class="text-white">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Sistem Manajemen Laundry
            </div>
            <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Kelola Laundry<br>
                <span class="text-blue-200">Lebih Mudah</span>
            </h1>
            <p class="text-blue-100 text-lg leading-relaxed mb-8 max-w-md">
                Platform manajemen laundry lengkap untuk admin, kasir, dan owner. Pantau transaksi, pelanggan, dan laporan dalam satu sistem.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login') }}" class="bg-white text-blue-700 px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-50 transition-colors shadow-lg">
                    Mulai Sekarang
                </a>
            </div>
            <div class="flex items-center gap-8 mt-10 pt-8 border-t border-white/20">
                <div>
                    <p class="text-2xl font-bold">3</p>
                    <p class="text-blue-200 text-sm">Level Akses</p>
                </div>
                <div class="w-px h-10 bg-white/20"></div>
                <div>
                    <p class="text-2xl font-bold">Real-time</p>
                    <p class="text-blue-200 text-sm">Laporan</p>
                </div>
                <div class="w-px h-10 bg-white/20"></div>
                <div>
                    <p class="text-2xl font-bold">Multi</p>
                    <p class="text-blue-200 text-sm">Outlet</p>
                </div>
            </div>
        </div>
        <div class="hidden lg:flex justify-center">
            <div class="float-animation">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 w-80">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-400/30 rounded-xl flex items-center justify-center text-xl">📊</div>
                        <div>
                            <p class="text-white font-semibold">Dashboard</p>
                            <p class="text-blue-200 text-xs">Ringkasan hari ini</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-xl p-3 flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Transaksi Hari Ini</span>
                            <span class="text-white font-bold">24</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Pendapatan</span>
                            <span class="text-green-300 font-bold">Rp 1.2jt</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3 flex justify-between items-center">
                            <span class="text-blue-100 text-sm">Antrian Proses</span>
                            <span class="text-yellow-300 font-bold">8</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Lengkap untuk Bisnis Laundry</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Semua yang Anda butuhkan untuk mengelola bisnis laundry secara profesional</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['icon'=>'🧾','title'=>'Manajemen Transaksi','desc'=>'Catat dan pantau setiap transaksi laundry dengan mudah, dari penerimaan hingga pengambilan.','color'=>'blue'],
                ['icon'=>'👥','title'=>'Data Pelanggan','desc'=>'Kelola database pelanggan setia Anda dan riwayat transaksi mereka secara lengkap.','color'=>'purple'],
                ['icon'=>'📈','title'=>'Laporan & Analitik','desc'=>'Laporan pendapatan harian, mingguan, dan bulanan untuk memantau performa bisnis.','color'=>'green'],
                ['icon'=>'🏪','title'=>'Multi Outlet','desc'=>'Kelola beberapa cabang laundry sekaligus dari satu dashboard terpusat.','color'=>'orange'],
                ['icon'=>'👤','title'=>'Manajemen Pengguna','desc'=>'Atur hak akses untuk Admin, Kasir, dan Owner dengan sistem role yang fleksibel.','color'=>'red'],
                ['icon'=>'📦','title'=>'Paket Layanan','desc'=>'Atur berbagai paket layanan laundry dengan harga dan satuan yang berbeda-beda.','color'=>'teal'],
            ] as $f)
            <div class="card-hover bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-12 h-12 bg-{{ $f['color'] }}-100 rounded-xl flex items-center justify-center text-2xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Role Section --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Akses Berdasarkan Peran</h2>
            <p class="text-gray-500">Setiap pengguna memiliki akses yang sesuai dengan tanggung jawabnya</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">👑</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Admin</h3>
                <p class="text-gray-500 text-sm mb-4">Akses penuh ke seluruh sistem</p>
                <ul class="text-left space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Kelola semua outlet</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Manajemen pengguna</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Semua transaksi</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> System log</li>
                </ul>
            </div>
            <div class="card-hover bg-white rounded-2xl p-8 border border-blue-200 text-center ring-2 ring-blue-500 ring-offset-2">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">💼</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kasir</h3>
                <p class="text-gray-500 text-sm mb-4">Operasional harian laundry</p>
                <ul class="text-left space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Input transaksi</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Kelola pelanggan</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Update status cucian</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Lihat laporan</li>
                </ul>
            </div>
            <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">📊</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Owner</h3>
                <p class="text-gray-500 text-sm mb-4">Pantau performa bisnis</p>
                <ul class="text-left space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Dashboard ringkasan</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Laporan pendapatan</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Statistik semua outlet</li>
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> Analitik bisnis</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="gradient-bg py-20">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-white mb-4">Siap Memulai?</h2>
        <p class="text-blue-100 mb-8">Masuk ke sistem dan mulai kelola bisnis laundry Anda hari ini.</p>
        <a href="{{ route('login') }}" class="inline-block bg-white text-blue-700 px-10 py-4 rounded-xl font-semibold text-lg hover:bg-blue-50 transition-colors shadow-xl">
            Masuk ke Sistem →
        </a>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="text-xl">🧺</span>
            <span class="text-white font-semibold">LaundryApp</span>
        </div>
        <p class="text-sm">© {{ date('Y') }} LaundryApp. Sistem Manajemen Laundry.</p>
    </div>
</footer>

</body>
</html>
