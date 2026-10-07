@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('header', 'Entri Transaksi Baru')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('transactions.store') }}" id="trxForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan <span class="text-red-500">*</span></label>
                <select name="customer_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('customer_id') border-red-500 @enderror">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->phone }})</option>
                    @endforeach
                </select>
                @error('customer_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Outlet <span class="text-red-500">*</span></label>
                <select name="outlet_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Outlet --</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o->id }}" {{ old('outlet_id') == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Selesai</label>
                <input type="date" name="estimated_done" value="{{ old('estimated_done') }}" min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Catatan tambahan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Item Rows --}}
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-gray-700">Item Cucian</h3>
                <button type="button" onclick="addRow()" class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700">+ Tambah Item</button>
            </div>
            @error('items')<p class="text-red-500 text-xs mb-2">{{ $message }}</p>@enderror

            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-2 text-left">Paket</th>
                            <th class="px-4 py-2 text-center w-28">Jumlah</th>
                            <th class="px-4 py-2 text-right w-36">Harga Satuan</th>
                            <th class="px-4 py-2 text-right w-36">Subtotal</th>
                            <th class="px-4 py-2 w-12"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr id="row-0">
                            <td class="px-4 py-2">
                                <select name="items[0][product_id]" onchange="updatePrice(0, this)" required class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} ({{ $p->unit }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="items[0][quantity]" id="qty-0" value="1" min="0.1" step="0.1" onchange="calcSubtotal(0)" class="w-full border border-gray-300 rounded px-2 py-1 text-sm text-center">
                            </td>
                            <td class="px-4 py-2 text-right">
                                <span id="price-0" class="text-gray-600">Rp 0</span>
                            </td>
                            <td class="px-4 py-2 text-right font-medium">
                                <span id="subtotal-0">Rp 0</span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button type="button" onclick="removeRow(0)" class="text-red-500 hover:text-red-700 text-lg">×</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                            <td class="px-4 py-3 text-right text-blue-700" id="grandTotal">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Transaksi</button>
            <a href="{{ route('transactions.index') }}" class="px-6 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>

<script>
const products = @json($productsJson);
let rowCount = 1;
const prices = {};

function updatePrice(idx, sel) {
    const opt = sel.options[sel.selectedIndex];
    const price = parseFloat(opt.dataset.price || 0);
    prices[idx] = price;
    document.getElementById('price-' + idx).textContent = 'Rp ' + price.toLocaleString('id-ID');
    calcSubtotal(idx);
}

function calcSubtotal(idx) {
    const qty = parseFloat(document.getElementById('qty-' + idx)?.value || 0);
    const price = prices[idx] || 0;
    const sub = qty * price;
    const el = document.getElementById('subtotal-' + idx);
    if (el) el.textContent = 'Rp ' + sub.toLocaleString('id-ID');
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
        total += parseFloat(el.textContent.replace(/[^0-9]/g, '')) || 0;
    });
    document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function addRow() {
    const idx = rowCount++;
    const opts = products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} (${p.unit})</option>`).join('');
    const row = `<tr id="row-${idx}">
        <td class="px-4 py-2"><select name="items[${idx}][product_id]" onchange="updatePrice(${idx}, this)" required class="w-full border border-gray-300 rounded px-2 py-1 text-sm"><option value="">-- Pilih Paket --</option>${opts}</select></td>
        <td class="px-4 py-2"><input type="number" name="items[${idx}][quantity]" id="qty-${idx}" value="1" min="0.1" step="0.1" onchange="calcSubtotal(${idx})" class="w-full border border-gray-300 rounded px-2 py-1 text-sm text-center"></td>
        <td class="px-4 py-2 text-right"><span id="price-${idx}" class="text-gray-600">Rp 0</span></td>
        <td class="px-4 py-2 text-right font-medium"><span id="subtotal-${idx}">Rp 0</span></td>
        <td class="px-4 py-2 text-center"><button type="button" onclick="removeRow(${idx})" class="text-red-500 hover:text-red-700 text-lg">×</button></td>
    </tr>`;
    document.getElementById('itemsBody').insertAdjacentHTML('beforeend', row);
}

function removeRow(idx) {
    const row = document.getElementById('row-' + idx);
    if (row && document.querySelectorAll('#itemsBody tr').length > 1) {
        row.remove();
        delete prices[idx];
        updateTotal();
    }
}
</script>
@endsection
