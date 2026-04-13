@extends('kepala.layouts.app')

@section('content')
<style>
/* BACKGROUND */
body {
    background: #e9e2d6;
    font-family: Poppins, sans-serif;
}

/* CONTAINER VINTAGE */
.container {
    max-width: 1050px;
    margin: 30px auto;
    background: #fffaf3;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.15);
    border: 1px solid #e6d3b3;
}

/* JUDUL */
.judul {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    font-weight: 700;
    color: #4b2e1e;
    letter-spacing: 0.5px;
}

/* FILTER */
form.filter-form {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    flex-wrap: wrap;
    align-items: flex-end;
    color: #4b2e1e;
}

/* SELECT */
form.filter-form select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #d8b58a;
    background: #fffdf8;
    color: #4b2e1e;
}

/* BUTTON FILTER */
form.filter-form button {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    border-radius: 8px;
    padding: 8px 14px;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

form.filter-form button:hover {
    opacity: 0.9;
}

/* LINK CETAK PDF */
form.filter-form a {
    background: #c07a2c;
    color: white;
    border-radius: 8px;
    padding: 8px 14px;
    text-decoration: none;
    display: inline-block;
    transition: 0.2s;
}

form.filter-form a:hover {
    background: #a9651f;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    border-radius: 12px;
    overflow: hidden;
    background: #fffdf8;
}

/* HEADER */
table th {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    padding: 14px;
    font-weight: 600;
    text-align: center;
    border-bottom: 2px solid #d8b58a;
}

/* BODY */
table td {
    padding: 14px 10px;
    border-bottom: 1px solid #ead9c3;
    text-align: center;
    color: #4b2e1e;
}

/* ALIGN KOLOM */
table th:nth-child(2),
table td:nth-child(2),
table th:nth-child(3),
table td:nth-child(3) {
    text-align: left;
}

/* HOVER ROW */
table tr {
    transition: 0.25s ease;
}

table tr:hover {
    background: #f7efe3;
}

/* BADGE VINTAGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: white;
}

.badge-warning {
    background: #c07a2c;
}

.badge-success {
    background: #2f7a4f;
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
    border: 1px solid #d8b58a;
    text-decoration: none;
    color: #6b3f24;
    background: #fffaf3;
    transition: 0.2s;
}

.pagination li a:hover {
    background: #6b3f24;
    color: white;
}

.pagination li.active span {
    background: #6b3f24;
    color: white;
    border-color: #6b3f24;
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
                      <th>Kelas</th> 
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    <tr>
                        <td>{{ $data->firstItem() + $i }}</td>
                        <td>{{ $d->user->name }}</td>
                        <td>{{ $d->user->kelas ?? '-' }}</td>
                        <td>{{ $d->buku->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>
                        <td>
   Rp {{ number_format($d->denda_real ?? 0, 0, ',', '.') }}
</td>
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
                      <td colspan="6" style="text-align:center;">Tidak ada data</td>
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
