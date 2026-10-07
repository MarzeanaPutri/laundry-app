@extends('layouts.app')
@section('title', 'Data Pelanggan')
@section('header', 'Data Pelanggan')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / telepon..." class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-gray-100 border px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Cari</button>
    </form>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Pelanggan</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Telepon</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Outlet</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $customer->name }}</td>
                <td class="px-6 py-3">{{ $customer->phone }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $customer->email ?? '-' }}</td>
                <td class="px-6 py-3">{{ $customer->outlet->name ?? '-' }}</td>
                <td class="px-6 py-3 text-center space-x-2">
                    <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:underline">Edit</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="inline" onsubmit="return confirm('Hapus pelanggan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pelanggan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $customers->links() }}</div>
</div>
@endsection
