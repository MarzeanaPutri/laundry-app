@extends('layouts.app')
@section('title', 'Transaksi')
@section('header', 'Manajemen Transaksi')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
    <form method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice / Pelanggan..." class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Status</option>
            @foreach(['pending','proses','selesai','diambil'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="outlet_id" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Outlet</option>
            @foreach($outlets as $outlet)
            <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 border px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Filter</button>
    </form>
    <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Transaksi Baru</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-4 py-3 text-left">Invoice</th>
                <th class="px-4 py-3 text-left">Pelanggan</th>
                <th class="px-4 py-3 text-left">Outlet</th>
                <th class="px-4 py-3 text-right">Total</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Pembayaran</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @php $statusColors = ['pending'=>'yellow','proses'=>'blue','selesai'=>'green','diambil'=>'gray'] @endphp
            @forelse($transactions as $trx)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-blue-600 text-xs">{{ $trx->invoice_number }}</td>
                <td class="px-4 py-3 font-medium">{{ $trx->customer->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $trx->outlet->name }}</td>
                <td class="px-4 py-3 text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $statusColors[$trx->status] }}-100 text-{{ $statusColors[$trx->status] }}-700">
                        {{ ucfirst($trx->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs {{ $trx->payment_status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $trx->payment_status == 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center space-x-2">
                    <a href="{{ route('transactions.show', $trx) }}" class="text-blue-600 hover:underline">Detail</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('transactions.destroy', $trx) }}" class="inline" onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $transactions->links() }}</div>
</div>
@endsection
