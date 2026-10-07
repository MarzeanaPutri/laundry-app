<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date|after_or_equal:date_from',
            'outlet_id'  => 'nullable|exists:outlets,id',
            'status'     => 'nullable|in:pending,proses,selesai,diambil',
        ]);

        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to   ?? now()->toDateString();

        $query = Transaction::with(['customer', 'outlet'])
            ->whereBetween(DB::raw('DATE(created_at)'), [$dateFrom, $dateTo]);

        if ($request->filled('outlet_id')) $query->where('outlet_id', $request->outlet_id);
        if ($request->filled('status'))    $query->where('status', $request->status);

        $transactions = (clone $query)->latest()->paginate(15)->withQueryString();

        $summary = (clone $query)->toBase()->selectRaw('
            COUNT(*) as total_transaksi,
            SUM(total_amount) as total_pendapatan,
            SUM(CASE WHEN payment_status = "lunas" THEN total_amount ELSE 0 END) as total_lunas,
            SUM(CASE WHEN payment_status = "belum_bayar" THEN total_amount ELSE 0 END) as total_belum_bayar
        ')->first();

        $byStatus = (clone $query)->toBase()
            ->selectRaw('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $outlets = Outlet::where('is_active', true)->get();

        return view('reports.index', compact('transactions', 'summary', 'byStatus', 'outlets', 'dateFrom', 'dateTo'));
    }
}
