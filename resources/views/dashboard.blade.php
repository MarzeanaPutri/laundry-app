@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Transaksi Hari Ini</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-lg">🧾</div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_transaksi_hari_ini'] }}</p>
        <p class="text-xs text-gray-400 mt-1">transaksi masuk</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pendapatan Hari Ini</p>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center text-lg">💰</div>
        </div>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">sudah lunas</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pendapatan Bulan Ini</p>
            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center text-lg">📈</div>
        </div>
        <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ now()->isoFormat('MMMM Y') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Pelanggan</p>
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center text-lg">👥</div>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pelanggan'] }}</p>
        <p class="text-xs text-gray-400 mt-1">pelanggan terdaftar</p>
    </div>
</div>

{{-- Status Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $statuses = [
        'pending'  => ['label'=>'Pending',   'icon'=>'⏳', 'bg'=>'bg-yellow-50', 'text'=>'text-yellow-600', 'border'=>'border-yellow-200'],
        'proses'   => ['label'=>'Diproses',  'icon'=>'🔄', 'bg'=>'bg-blue-50',   'text'=>'text-blue-600',   'border'=>'border-blue-200'],
        'selesai'  => ['label'=>'Selesai',   'icon'=>'✅', 'bg'=>'bg-green-50',  'text'=>'text-green-600',  'border'=>'border-green-200'],
        'diambil'  => ['label'=>'Diambil',   'icon'=>'📦', 'bg'=>'bg-gray-50',   'text'=>'text-gray-600',   'border'=>'border-gray-200'],
    ];
    @endphp
    @foreach($statuses as $key => $s)
    <div class="bg-white rounded-2xl border {{ $s['border'] }} p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $s['label'] }}</p>
            <div class="w-9 h-9 {{ $s['bg'] }} rounded-xl flex items-center justify-center text-lg">{{ $s['icon'] }}</div>
        </div>
        <p class="text-3xl font-bold {{ $s['text'] }}">{{ $stats['total_' . $key] }}</p>
        <p class="text-xs text-gray-400 mt-1">cucian</p>
    </div>
    @endforeach
</div>

{{-- Recent Transactions --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
        <div>
            <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
            <p class="text-xs text-gray-400 mt-0.5">5 transaksi terakhir</p>
        </div>
        @if(!auth()->user()->isOwner())
        <a href="{{ route('transactions.index') }}"
            class="text-sm text-blue-600 hover:text-blue-700 font-medium bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
            Lihat Semua →
        </a>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Outlet</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono text-blue-600 text-xs font-medium">{{ $trx->invoice_number }}</td>
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $trx->customer->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $trx->outlet->name }}</td>
                    <td class="px-6 py-4 text-gray-900 font-semibold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                        $badge = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'proses'  => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'diambil' => 'bg-gray-100 text-gray-600',
                        ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge[$trx->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-4xl mb-2">🧺</div>
                        <p class="text-gray-400 text-sm">Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
