@extends('layouts.app')
@section('title', 'Tambah Paket')
@section('header', 'Tambah Paket Laundry')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('products.store') }}" class="space-y-4">
        @csrf
        <x-form-input label="Nama Paket" name="name" required placeholder="Contoh: Cuci Kiloan Reguler" />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
            <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="kiloan" {{ old('type') == 'kiloan' ? 'selected' : '' }}>Kiloan</option>
                <option value="satuan" {{ old('type') == 'satuan' ? 'selected' : '' }}>Satuan</option>
                <option value="express" {{ old('type') == 'express' ? 'selected' : '' }}>Express</option>
            </select>
        </div>
        <x-form-input label="Harga" name="price" type="number" required placeholder="7000" />
        <x-form-input label="Satuan" name="unit" required placeholder="kg / pcs / item" value="kg" />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Keterangan paket...">{{ old('description') }}</textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('products.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
