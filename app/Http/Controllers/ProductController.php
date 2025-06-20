<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PDF;
use Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sortBy = $request->sort_by ?? 'created_at';
        $order = $request->order ?? 'desc';
    
        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%$search%")
                      ->orWhere('deskripsi_produk', 'like', "%$search%");
            })
            ->orderBy($sortBy, $order)
            ->paginate(10);
    
        return view('products.index', compact('products', 'search', 'sortBy', 'order'));
    }
    
    

    public function create()
    {
        return view('products.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
    public function exportPDF()
    {
        $products = Product::all();
        $pdf = PDF::loadView('products.pdf', compact('products'));
        return $pdf->download('products.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
