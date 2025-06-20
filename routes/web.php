<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function(){ return redirect()->route('products.index'); });
Route::resource('products', ProductController::class);
Route::get('products-export/pdf', [ProductController::class, 'exportPDF'])->name('products.export.pdf');
Route::get('products-export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
Route::get('/a', function () {
    return view('welcome');
});
