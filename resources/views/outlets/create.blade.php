@extends('layouts.app')
@section('title', 'Tambah Outlet')
@section('header', 'Tambah Outlet')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('outlets.store') }}" class="space-y-4">
        @csrf
        <x-form-input label="Nama Outlet" name="name" required placeholder="Contoh: Cabang Utama" />
        <x-form-input label="Alamat" name="address" required placeholder="Jl. Merdeka No. 1" />
        <x-form-input label="Telepon" name="phone" placeholder="021-12345678" />
        <x-form-input label="Email" name="email" type="email" placeholder="outlet@example.com" />
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('outlets.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
