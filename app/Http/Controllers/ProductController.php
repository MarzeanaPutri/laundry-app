<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'type'        => 'required|in:kiloan,satuan,express',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
        ]);

        $product = Product::create($data);
        SystemLog::record('create', "Produk '{$product->name}' ditambahkan.", 'Product', $product->id);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'type'        => 'required|in:kiloan,satuan,express',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'boolean',
        ]);

        $product->update($data);
        SystemLog::record('update', "Produk '{$product->name}' diperbarui.", 'Product', $product->id);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();
        SystemLog::record('delete', "Produk '{$name}' dihapus.", 'Product', $product->id);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
