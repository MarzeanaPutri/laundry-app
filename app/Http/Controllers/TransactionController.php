<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\SystemLog;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'outlet', 'user']);

        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('payment_status')) $query->where('payment_status', $request->payment_status);
        if ($request->filled('outlet_id'))      $query->where('outlet_id', $request->outlet_id);
        if ($request->filled('search')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                  ->orWhere('invoice_number', 'like', "%{$request->search}%");
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();
        $outlets = Outlet::where('is_active', true)->get();

        return view('transactions.index', compact('transactions', 'outlets'));
    }

    public function create()
    {
        $customers    = Customer::orderBy('name')->get();
        $outlets      = Outlet::where('is_active', true)->get();
        $products     = Product::where('is_active', true)->orderBy('name')->get();
        $productsJson = $products->map(function ($p) {
            return ['id' => $p->id, 'name' => $p->name, 'price' => $p->price, 'unit' => $p->unit];
        })->values();
        return view('transactions.create', compact('customers', 'outlets', 'products', 'productsJson'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'outlet_id'      => 'required|exists:outlets,id',
            'estimated_done' => 'nullable|date|after_or_equal:today',
            'notes'          => 'nullable|string|max:500',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product  = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total   += $subtotal;
                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $subtotal,
                ];
            }

            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoice(),
                'customer_id'    => $request->customer_id,
                'outlet_id'      => $request->outlet_id,
                'user_id'        => auth()->id(),
                'total_amount'   => $total,
                'estimated_done' => $request->estimated_done,
                'notes'          => $request->notes,
            ]);

            foreach ($itemsData as $item) {
                $transaction->items()->create($item);
            }

            SystemLog::record('create', "Transaksi '{$transaction->invoice_number}' dibuat.", 'Transaction', $transaction->id);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'outlet', 'user', 'items.product']);
        return view('transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status'         => 'required|in:pending,proses,selesai,diambil',
            'payment_status' => 'required|in:belum_bayar,lunas',
            'paid_amount'    => 'required_if:payment_status,lunas|numeric|min:0',
        ]);

        $transaction->update([
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
            'paid_amount'    => $request->payment_status === 'lunas' ? $request->paid_amount : $transaction->paid_amount,
        ]);

        SystemLog::record('update', "Status transaksi '{$transaction->invoice_number}' diubah ke '{$request->status}'.", 'Transaction', $transaction->id);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $invoice = $transaction->invoice_number;
        $transaction->delete();
        SystemLog::record('delete', "Transaksi '{$invoice}' dihapus.", 'Transaction', $transaction->id);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
