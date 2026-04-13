@extends('kepala.layouts.app')

@section('title', 'Laporan Denda')
<style>
/* BACKGROUND PAGE */
body {
    background: #e9e2d6;
    font-family: 'Poppins', sans-serif;
}

/* CARD VINTAGE */
.card {
    background: #fffaf3;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.15);
    max-width: 2000px;
    margin: 25px auto;
    border: 1px solid #e6d3b3;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    background: #fffdf8;
}

/* HEADER */
.table-modern th {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: #fff;
    padding: 14px;
    text-align: center;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d8b58a;
}

/* BODY */
.table-modern td {
    padding: 14px 10px;
    border-bottom: 1px solid #ead9c3;
    text-align: center;
    color: #4b2e1e;
}

/* KOLOM ALIGN */
.table-modern th:nth-child(1),
.table-modern td:nth-child(1) {
    text-align: left;
}

.table-modern th:nth-child(2),
.table-modern td:nth-child(2) {
    text-align: left;
}

/* HOVER */
.table-modern tr {
    transition: 0.25s ease;
}

.table-modern tr:hover {
    background: #f7efe3;
}

/* BADGE VINTAGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    letter-spacing: 0.3px;
}

.badge.red {
    background: #b23a3a;
}

.badge.orange {
    background: #c07a2c;
}

.badge.green {
    background: #2f7a4f;
}
.badge.blue {
    background: #2471dd;
}

/* DENDA */
strong {
    font-size: 14px;
    color: #b23a3a;
}

/* INFO TEXT */
.card div {
    margin-top: 12px;
    font-size: 13px;
    color: #6b5a4a;
    text-align: center;
}

/* PAGINATION VINTAGE */
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
    color: #fff;
}

.pagination li.active span {
    background: #6b3f24;
    color: #fff;
    border-color: #6b3f24;
}
.table-modern {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* 🔥 penting biar kolom tidak numpuk */
}

.table-modern th,
.table-modern td {
    word-wrap: break-word;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 13px;
}
.table-modern th:nth-child(1),
.table-modern td:nth-child(1) { width: 14%; }

.table-modern th:nth-child(2),
.table-modern td:nth-child(2) { width: 10%; }

.table-modern th:nth-child(3),
.table-modern td:nth-child(3) { width: 18%; }

.table-modern th:nth-child(4),
.table-modern td:nth-child(4) { width: 10%; }

.table-modern th:nth-child(5),
.table-modern td:nth-child(5) { width: 12%; }

.table-modern th:nth-child(6),
.table-modern td:nth-child(6) { width: 15%; }

.table-modern th:nth-child(7),
.table-modern td:nth-child(7) { width: 15%; }
</style>
@section('content')

    <div class="card">
        <table class="table-modern">
            <thead>
                <tr>
                    <tr>
    <th>Nama</th>
    <th>Kelas</th> <!-- 🔥 tambah -->
    <th>Buku</th>
    <th>Jumlah</th>
    <th>Terlambat</th> <!-- 🔥 tambah -->
    <th>Total Denda</th>
    <th>Status</th>
</tr>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)
                    <tr>
                        <td>{{ $d->user->name }}</td>
                            <td>{{ $d->user->kelas ?? '-' }}</td> <!-- 🔥 kelas -->

                        <td>{{ $d->buku->judul }}</td>
                        <td>{{ $d->jumlah ?? 1 }}</td>

    <td>{{ $d->terlambat }} Hari</td> <!-- 🔥 terlambat -->
                        <td>
                            <strong style="color:#ef4444;">
                           Rp {{ number_format($d->terlambat * 5000 * $d->jumlah, 0, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                           @if ($d->terlambat == 0)
    <span class="badge blue">Aman (Tidak Telat)</span>

@elseif ($d->status_pembayaran == 'lunas')
    <span class="badge green">Lunas</span>

@elseif ($d->status_pembayaran == 'menunggu')
    <span class="badge orange">Menunggu</span>

@else
    <span class="badge red">Belum Bayar</span>
@endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Tidak ada data denda
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- INFO --}}
        <div style="margin-top:10px; font-size:13px; color:#64748b;">
            Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
            dari {{ $data->total() }} data
        </div>

        {{-- PAGINATION --}}
        <div class="pagination">
            {{ $data->links() }}
        </div>

    </div>

@endsection
