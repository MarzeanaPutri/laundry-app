<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Outlet;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('outlet');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }

        $customers = $query->latest()->paginate(10)->withQueryString();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $outlets = Outlet::where('is_active', true)->get();
        return view('customers.create', compact('outlets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'phone'     => 'required|string|max:20|unique:customers,phone',
            'email'     => 'nullable|email|max:100',
            'address'   => 'nullable|string|max:255',
            'outlet_id' => 'nullable|exists:outlets,id',
        ]);

        $customer = Customer::create($data);
        SystemLog::record('create', "Pelanggan '{$customer->name}' didaftarkan.", 'Customer', $customer->id);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil didaftarkan.');
    }

    public function edit(Customer $customer)
    {
        $outlets = Outlet::where('is_active', true)->get();
        return view('customers.edit', compact('customer', 'outlets'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'phone'     => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'email'     => 'nullable|email|max:100',
            'address'   => 'nullable|string|max:255',
            'outlet_id' => 'nullable|exists:outlets,id',
        ]);

        $customer->update($data);
        SystemLog::record('update', "Data pelanggan '{$customer->name}' diperbarui.", 'Customer', $customer->id);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();
        SystemLog::record('delete', "Pelanggan '{$name}' dihapus.", 'Customer', $customer->id);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
