<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Outlet;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_transaksi_hari_ini' => Transaction::whereDate('created_at', today())->count(),
            'total_pending'            => Transaction::where('status', 'pending')->count(),
            'total_proses'             => Transaction::where('status', 'proses')->count(),
            'total_selesai'            => Transaction::where('status', 'selesai')->count(),
            'total_diambil'            => Transaction::where('status', 'diambil')->count(),
            'pendapatan_hari_ini'      => Transaction::whereDate('created_at', today())->where('payment_status', 'lunas')->sum('total_amount'),
            'pendapatan_bulan_ini'     => Transaction::whereMonth('created_at', now()->month)->where('payment_status', 'lunas')->sum('total_amount'),
            'total_pelanggan'          => Customer::count(),
            'total_outlet'             => Outlet::where('is_active', true)->count(),
        ];

        if (auth()->user()->isAdmin()) {
            $stats['total_user'] = User::count();
        }

        $recentTransactions = Transaction::with(['customer', 'outlet'])
            ->latest()->limit(5)->get();

        return view('dashboard', compact('stats', 'recentTransactions'));
    }
}
