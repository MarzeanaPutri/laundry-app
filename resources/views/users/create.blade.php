@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
        @csrf
        <x-form-input label="Nama Lengkap" name="name" required placeholder="Nama pengguna" />
        <x-form-input label="Email" name="email" type="email" required placeholder="email@example.com" />
        <x-form-input label="Password" name="password" type="password" required placeholder="Min. 8 karakter" />
        <x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" required />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
            <select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Outlet</label>
            <select name="outlet_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Tidak Ada --</option>
                @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('users.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
