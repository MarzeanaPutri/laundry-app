@extends('layouts.app')
@section('title', 'Edit Outlet')
@section('header', 'Edit Outlet')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('outlets.update', $outlet) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-input label="Nama Outlet" name="name" :value="$outlet->name" required />
        <x-form-input label="Alamat" name="address" :value="$outlet->address" required />
        <x-form-input label="Telepon" name="phone" :value="$outlet->phone" />
        <x-form-input label="Email" name="email" type="email" :value="$outlet->email" />
        <div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ $outlet->is_active ? 'checked' : '' }} class="rounded">
                Outlet Aktif
            </label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('outlets.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
