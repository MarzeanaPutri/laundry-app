@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('header', 'Detail Transaksi')

@section('content')
@php $statusColors = ['pending'=>'yellow','proses'=>'blue','selesai'=>'green','diambil'=>'gray'] @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Detail Kiri --}}
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold font-mono text-blue-700">{{ $transaction->invoice_number }}</h3>
                    <p class="text-gray-500 text-sm">{{ $transaction->created_at->isoFormat('dddd, D MMMM Y HH:mm') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm bg-{{ $statusColors[$transaction->status] }}-100 text-{{ $statusColors[$transaction->status] }}-700 font-medium">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                <div><p class="text-gray-500">Pelanggan</p><p class="font-medium">{{ $transaction->customer->name }}</p><p class="text-gray-400">{{ $transaction->customer->phone }}</p></div>
                <div><p class="text-gray-500">Outlet</p><p class="font-medium">{{ $transaction->outlet->name }}</p></div>
                <div><p class="text-gray-500">Kasir</p><p class="font-medium">{{ $transaction->user->name }}</p></div>
                <div><p class="text-gray-500">Estimasi Selesai</p><p class="font-medium">{{ $transaction->estimated_done?->isoFormat('D MMM Y') ?? '-' }}</p></div>
            </div>

            @if($transaction->notes)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-800">
                <strong>Catatan:</strong> {{ $transaction->notes }}
            </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b"><h3 class="font-semibold">Item Cucian</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Paket</th>
                        <th class="px-6 py-3 text-center">Jumlah</th>
                        <th class="px-6 py-3 text-right">Harga</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaction->items as $item)
                    <tr>
                        <td class="px-6 py-3">{{ $item->product->name }}</td>
                        <td class="px-6 py-3 text-center">{{ $item->quantity }} {{ $item->product->unit }}</td>
                        <td class="px-6 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right">Total</td>
                        <td class="px-6 py-3 text-right text-blue-700">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Update Status --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold mb-4">Update Status</h3>
            <form method="POST" action="{{ route('transactions.updateStatus', $transaction) }}" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Cucian</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['pending','proses','selesai','diambil'] as $s)
                        <option value="{{ $s }}" {{ $transaction->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="payment_status" id="paymentStatus" onchange="togglePaid()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="belum_bayar" {{ $transaction->payment_status == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="lunas" {{ $transaction->payment_status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div id="paidAmountField" class="{{ $transaction->payment_status == 'lunas' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dibayar</label>
                    <input type="number" name="paid_amount" value="{{ $transaction->paid_amount }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm">Perbarui Status</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow p-6 text-sm space-y-2">
            <div class="flex justify-between"><span class="text-gray-500">Total Tagihan</span><span class="font-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Dibayar</span><span class="font-bold text-green-600">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span></div>
            <div class="flex justify-between border-t pt-2"><span class="text-gray-500">Sisa</span><span class="font-bold text-red-600">Rp {{ number_format($transaction->total_amount - $transaction->paid_amount, 0, ',', '.') }}</span></div>
        </div>

        <a href="{{ route('transactions.index') }}" class="block text-center px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">← Kembali</a>
    </div>
</div>

<script>
function togglePaid() {
    const val = document.getElementById('paymentStatus').value;
    document.getElementById('paidAmountField').classList.toggle('hidden', val !== 'lunas');
}
</script>
@endsection
