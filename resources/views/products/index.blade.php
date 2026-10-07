@extends('layouts.app')
@section('title', 'Paket Laundry')
@section('header', 'Manajemen Paket Laundry')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-500 text-sm">Total: {{ $products->total() }} paket</p>
    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Paket</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-6 py-3 text-left">Nama Paket</th>
                <th class="px-6 py-3 text-left">Tipe</th>
                <th class="px-6 py-3 text-right">Harga</th>
                <th class="px-6 py-3 text-center">Satuan</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $product->name }}</td>
                <td class="px-6 py-3">
                    @php $typeColors = ['kiloan'=>'blue','satuan'=>'purple','express'=>'orange'] @endphp
                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $typeColors[$product->type] }}-100 text-{{ $typeColors[$product->type] }}-700">
                        {{ ucfirst($product->type) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-right font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-3 text-center">{{ $product->unit }}</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-3 text-center space-x-2">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus paket ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada paket laundry.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $products->links() }}</div>
</div>
@endsection
