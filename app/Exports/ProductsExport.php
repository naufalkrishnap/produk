<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    public function collection()
    {
        return Product::all(['id','nama_produk', 'deskripsi_produk', 'harga', 'stok']);
    }
}
