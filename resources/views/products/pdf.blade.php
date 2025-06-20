<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h3>Daftar Produk</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->deskripsi_produk }}</td>
                <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
                <td>{{ $p->stok }}</td>
                <td>{{ $p->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
