@extends('layouts.app')
@section('title', 'Laporan')
@section('header', 'Laporan Transaksi')

@section('content')
{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Outlet</label>
            <select name="outlet_id" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Outlet</option>
                @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                @foreach(['pending','proses','selesai','diambil'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700">Tampilkan</button>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-gray-500">Total Transaksi</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $summary->total_transaksi ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-gray-500">Total Pendapatan</p>
        <p class="text-xl font-bold text-gray-700 mt-1">Rp {{ number_format($summary->total_pendapatan ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-gray-500">Sudah Lunas</p>
        <p class="text-xl font-bold text-green-600 mt-1">Rp {{ number_format($summary->total_lunas ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-gray-500">Belum Bayar</p>
        <p class="text-xl font-bold text-red-600 mt-1">Rp {{ number_format($summary->total_belum_bayar ?? 0, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Status Breakdown --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php $statusColors = ['pending'=>'yellow','proses'=>'blue','selesai'=>'green','diambil'=>'gray'] @endphp
    @foreach(['pending','proses','selesai','diambil'] as $s)
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-{{ $statusColors[$s] }}-400">
        <p class="text-xs text-gray-500">{{ ucfirst($s) }}</p>
        <p class="text-2xl font-bold text-{{ $statusColors[$s] }}-600">{{ $byStatus[$s] ?? 0 }}</p>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-gray-700">Daftar Transaksi ({{ $dateFrom }} s/d {{ $dateTo }})</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Invoice</th>
                <th class="px-4 py-3 text-left">Pelanggan</th>
                <th class="px-4 py-3 text-left">Outlet</th>
                <th class="px-4 py-3 text-right">Total</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Pembayaran</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($transactions as $trx)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-blue-600 text-xs">{{ $trx->invoice_number }}</td>
                <td class="px-4 py-3">{{ $trx->customer->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $trx->outlet->name }}</td>
                <td class="px-4 py-3 text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $statusColors[$trx->status] }}-100 text-{{ $statusColors[$trx->status] }}-700">{{ ucfirst($trx->status) }}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs {{ $trx->payment_status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $trx->payment_status == 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $trx->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $transactions->links() }}</div>
</div>
@endsection
