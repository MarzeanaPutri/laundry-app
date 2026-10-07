@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('header', 'Edit Pengguna')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-input label="Nama Lengkap" name="name" :value="$user->name" required />
        <x-form-input label="Email" name="email" type="email" :value="$user->email" required />
        <x-form-input label="Password Baru" name="password" type="password" placeholder="Kosongkan jika tidak diubah" />
        <x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['kasir','admin','owner'] as $role)
                <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Outlet</label>
            <select name="outlet_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Tidak Ada --</option>
                @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded">
                Akun Aktif
            </label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('users.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
