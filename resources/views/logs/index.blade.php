@extends('layouts.app')
@section('title', 'System Log')
@section('header', 'System Activity Log')

@section('content')
<div class="flex gap-3 mb-4">
    <form method="GET" class="flex gap-2">
        <select name="action" class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Aksi</option>
            @foreach(['login','logout','create','update','delete'] as $a)
            <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 border px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="px-6 py-3 text-left">Waktu</th>
                <th class="px-6 py-3 text-left">Pengguna</th>
                <th class="px-6 py-3 text-center">Aksi</th>
                <th class="px-6 py-3 text-left">Deskripsi</th>
                <th class="px-6 py-3 text-left">IP</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @php
            $actionColors = ['login'=>'green','logout'=>'gray','create'=>'blue','update'=>'yellow','delete'=>'red'];
            @endphp
            @forelse($logs as $log)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                <td class="px-6 py-3 font-medium">{{ $log->user->name ?? 'System' }}</td>
                <td class="px-6 py-3 text-center">
                    @php $c = $actionColors[$log->action] ?? 'gray' @endphp
                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $c }}-100 text-{{ $c }}-700">{{ ucfirst($log->action) }}</span>
                </td>
                <td class="px-6 py-3 text-gray-600">{{ $log->description }}</td>
                <td class="px-6 py-3 text-gray-400 font-mono text-xs">{{ $log->ip_address }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada log aktivitas.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $logs->links() }}</div>
</div>
@endsection
