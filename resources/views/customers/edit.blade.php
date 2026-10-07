@extends('layouts.app')
@section('title', 'Edit Pelanggan')
@section('header', 'Edit Data Pelanggan')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-input label="Nama Lengkap" name="name" :value="$customer->name" required />
        <x-form-input label="No. Telepon" name="phone" :value="$customer->phone" required />
        <x-form-input label="Email" name="email" type="email" :value="$customer->email" />
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $customer->address) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Outlet</label>
            <select name="outlet_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Outlet --</option>
                @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ old('outlet_id', $customer->outlet_id) == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('customers.index') }}" class="px-5 py-2 rounded-lg border hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection
