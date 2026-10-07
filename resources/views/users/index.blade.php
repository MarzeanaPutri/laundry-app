@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna')

@section('content')
<div class="flex justify-between items-center mb-4">
    <p class="text-gray-500 text-sm">Total: {{ $users->total() }} pengguna</p>
    <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Pengguna</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-center">Role</th>
                <th class="px-6 py-3 text-left">Outlet</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @php $roleColors = ['admin'=>'red','kasir'=>'blue','owner'=>'purple'] @endphp
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $roleColors[$user->role] }}-100 text-{{ $roleColors[$user->role] }}-700">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-3">{{ $user->outlet->name ?? '-' }}</td>
                <td class="px-6 py-3 text-center">
                    <span class="px-2 py-1 rounded-full text-xs {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-3 text-center space-x-2">
                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $users->links() }}</div>
</div>
@endsection
