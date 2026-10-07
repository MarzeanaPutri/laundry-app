@extends('layouts.app')
@section('title', 'Manajemen Outlet')
@section('header', 'Manajemen Outlet')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-500 text-sm">Total: {{ $outlets->total() }} outlet</p>
    <a href="{{ route('outlets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Outlet</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-6 py-3 text-left">Nama Outlet</th>
                <th class="px-6 py-3 text-left">Alamat</th>
                <th class="px-6 py-3 text-left">Telepon</th>
                <th class="px-6 py-3 text-center">Pengguna</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($outlets as $outlet)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $outlet->name }}</td>
                <td class="px-6 py-3 text-gray-600">{{ $outlet->address }}</td>
                <td class="px-6 py-3">{{ $outlet->phone ?? '-' }}</td>
                <td class="px-6 py-3 text-center">{{ $outlet->users_count }}</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs {{ $outlet->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $outlet->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-3 text-center space-x-2">
                    <a href="{{ route('outlets.edit', $outlet) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('outlets.destroy', $outlet) }}" class="inline" onsubmit="return confirm('Hapus outlet ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada outlet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $outlets->links() }}</div>
</div>
@endsection
