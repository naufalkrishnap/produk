<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['nama_produk', 'deskripsi_produk', 'harga', 'stok'];
}
