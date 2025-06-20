@extends('layouts.app')
@section('content')
@stack('scripts')

<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ isset($product) ? 'Edit' : 'Tambah' }} Produk</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                        value="{{ old('nama_produk', $product->nama_produk ?? '') }}" required>
                    @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_produk" class="form-control @error('deskripsi_produk') is-invalid @enderror"
                        rows="3">{{ old('deskripsi_produk', $product->deskripsi_produk ?? '') }}</textarea>
                    @error('deskripsi_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" step="0.01" name="harga" class="form-control @error('harga') is-invalid @enderror"
                        value="{{ old('harga', $product->harga ?? '') }}" required>
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                        value="{{ old('stok', $product->stok ?? '') }}" required>
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">{{ isset($product) ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
