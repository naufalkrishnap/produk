@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Daftar Produk</h2>
        <div>
            <a href="{{ route('products.export.excel') }}" class="btn btn-success me-2">Export Excel</a>
            <a href="{{ route('products.export.pdf') }}" class="btn btn-danger me-2">Export PDF</a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control shadow-sm" placeholder="Cari produk...">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Cari</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    @php
                        $columns = [
                            'id' => 'ID',
                            'nama_produk' => 'Nama',
                            'deskripsi_produk' => 'Deskripsi',
                            'harga' => 'Harga',
                            'stok' => 'Stok',
                            'created_at' => 'Dibuat',
                            'updated_at' => 'Diperbarui'
                        ];
                        $currentSort = request('sort_by');
                        $currentOrder = request('order') === 'asc' ? 'asc' : 'desc';
                    @endphp
                    @foreach($columns as $col => $label)
                        @php
                            $isSorted = $currentSort === $col;
                            $nextOrder = $isSorted && $currentOrder === 'asc' ? 'desc' : 'asc';
                            $arrow = $isSorted ? ($currentOrder === 'asc' ? '▲' : '▼') : '↕';
                        @endphp
                        <th class="text-nowrap">
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort_by' => $col, 'order' => $nextOrder])) }}"
                               class="text-decoration-none text-dark">
                                {{ $label }} <small>{{ $arrow }}</small>
                            </a>
                        </th>
                    @endforeach
                    <th class="text-center text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>{{ $p->deskripsi_produk }}</td>
                        <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
                        <td>{{ $p->stok }}</td>
                        <td>{{ $p->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $p->updated_at->format('d-m-Y H:i:s') }}</td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('{{ route('products.destroy', $p) }}')">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->appends(request()->all())->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.
      </div>
      <div class="modal-footer">
        <form id="deleteForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(url) {
        const form = document.getElementById('deleteForm');
        form.action = url;

        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>
@endpush
