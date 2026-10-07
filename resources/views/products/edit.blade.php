@extends('layouts.app')
@section('title', 'Edit Paket')
@section('header', 'Edit Paket Laundry')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-input label="Nama Paket" name="name" :value="$product->name" required />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
            <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['kiloan','satuan','express'] as $type)
                <option value="{{ $type }}" {{ old('type', $product->type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <x-form-input label="Harga" name="price" type="number" :value="$product->price" required />
        <x-form-input label="Satuan" name="unit" :value="$product->unit" required />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded">
                Paket Aktif
            </label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('products.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
