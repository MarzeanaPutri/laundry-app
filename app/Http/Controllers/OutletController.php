<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::withCount(['users', 'customers', 'transactions'])->latest()->paginate(10);
        return view('outlets.index', compact('outlets'));
    }

    public function create()
    {
        return view('outlets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:100',
        ]);

        $outlet = Outlet::create($data);
        SystemLog::record('create', "Outlet '{$outlet->name}' ditambahkan.", 'Outlet', $outlet->id);

        return redirect()->route('outlets.index')->with('success', 'Outlet berhasil ditambahkan.');
    }

    public function edit(Outlet $outlet)
    {
        return view('outlets.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'address'   => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $outlet->update($data);
        SystemLog::record('update', "Outlet '{$outlet->name}' diperbarui.", 'Outlet', $outlet->id);

        return redirect()->route('outlets.index')->with('success', 'Outlet berhasil diperbarui.');
    }

    public function destroy(Outlet $outlet)
    {
        $name = $outlet->name;
        $outlet->delete();
        SystemLog::record('delete', "Outlet '{$name}' dihapus.", 'Outlet', $outlet->id);

        return redirect()->route('outlets.index')->with('success', 'Outlet berhasil dihapus.');
    }
}
