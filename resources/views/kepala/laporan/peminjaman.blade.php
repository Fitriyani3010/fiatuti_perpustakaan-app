@extends('kepala.layouts.app')

@section('content')
    <style>
       /* CONTAINER */
.container {
    max-width: 1050px;
    margin: 30px auto;
    font-family: Poppins, sans-serif;
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.judul {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    font-weight: 700;
    color: #333;
}

/* FILTER */
form.filter-form {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    flex-wrap: wrap;
    align-items: flex-end;
}

form.filter-form select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    background: #f9fafb;
}

/* BUTTON */
form.filter-form button {
    background: #6b3f24;
    color: white;
    border-radius: 8px;
    padding: 8px 14px;
    border: none;
}

/* 🔥 FIX UNDERLINE CETAK PDF */
form.filter-form a {
    background: #ffc107;
    color: black;
    border-radius: 8px;
    padding: 8px 14px;
    text-decoration: none; /* ⬅️ INI YANG NGILANGIN UNDERLINE */
    display: inline-block;
}

/* TABLE WRAPPER (BIAR LEBIH RAPI) */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
table th {
    background: #6b3f24;
    color: white;
    padding: 14px;
    font-weight: 600;
    text-align: center;
}

/* DATA */
table td {
    padding: 14px 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
    vertical-align: middle;
}

/* 🔥 RAPIIIN LEBAR KOLOM */
table th:nth-child(1),
table td:nth-child(1) {
    width: 60px;
}

table th:nth-child(2),
table td:nth-child(2) {
    width: 20%;
    text-align: left;
}

table th:nth-child(3),
table td:nth-child(3) {
    width: 25%;
    text-align: left;
}

table th:nth-child(4),
table td:nth-child(4) {
    width: 150px;
}

table th:nth-child(5),
table td:nth-child(5) {
    width: 120px;
}

/* ROW HOVER */
table tr {
    transition: 0.2s;
}

table tr:hover {
    background: #f9f6f3;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
}

.badge-warning {
    background: #f59e0b;
}

.badge-success {
    background: #22c55e;
}

.badge-secondary {
    background: #6b7280;
}

/* PAGINATION */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    gap: 6px;
}

.pagination li a,
.pagination li span {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    text-decoration: none;
}

.pagination li.active span {
    background: #6b3f24;
    color: white;
}
    </style>

    <div class="container">
        <h2 class="judul">Laporan Peminjaman Buku</h2>

        <!-- Filter Bulan & Tahun -->
        <form action="{{ route('kepala.laporan.peminjaman') }}" method="GET" class="filter-form">
            <div>
                <label>Bulan:</label>
                <select name="bulan">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label>Tahun:</label>
                <select name="tahun">
                    @for ($y = date('Y') - 5; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <button type="submit">Filter</button>
                <a href="{{ route('kepala.laporan.peminjaman.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    target="_blank">Cetak PDF</a>
            </div>
        </form>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    <tr>
                        <td>{{ $data->firstItem() + $i }}</td>
                        <td>{{ $d->user->name }}</td>
                        <td>{{ $d->buku->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>
                        <td>
                            @if ($d->status == 'dipinjam')
                                <span class="badge badge-warning">Dipinjam</span>
                            @elseif($d->status == 'dikembalikan')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-secondary">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div>
            {{ $data->links() }}
        </div>
    </div>
@endsection
