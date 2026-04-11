@extends('kepala.layouts.app')

@section('title', 'Laporan Denda')
<style>
    /* CARD */
.card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    max-width: 2000px;
    margin: 25px auto;
    font-family: Poppins, sans-serif;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
.table-modern th {
    background: #6b3f24;
    color: white;
    padding: 14px;
    text-align: center;
    font-weight: 600;
}

/* BODY */
.table-modern td {
    padding: 14px 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

/* RAPIIIN KOLOM */
.table-modern th:nth-child(1),
.table-modern td:nth-child(1) {
    width: 25%;
    text-align: left;
}

.table-modern th:nth-child(2),
.table-modern td:nth-child(2) {
    width: 25%;
    text-align: left;
}

.table-modern th:nth-child(3),
.table-modern td:nth-child(3) {
    width: 20%;
}

.table-modern th:nth-child(4),
.table-modern td:nth-child(4) {
    width: 20%;
}

/* HOVER */
.table-modern tr {
    transition: 0.2s;
}

.table-modern tr:hover {
    background: #f9f6f3;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    color: white;
}

.badge.red {
    background: #ef4444;
}

.badge.orange {
    background: #f59e0b;
}

.badge.green {
    background: #22c55e;
}

/* TEXT DENDA */
strong {
    font-size: 14px;
}

/* INFO TEXT */
.card div {
    margin-top: 12px;
    font-size: 13px;
    color: #64748b;
    text-align: center;
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
    color: #333;
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
@section('content')

    <div class="card">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Total Denda</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $d)
                    <tr>
                        <td>{{ $d->user->name }}</td>
                        <td>{{ $d->buku->judul }}</td>
                        <td>
                            <strong style="color:#ef4444;">
                                Rp {{ number_format($d->denda, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            @if ($d->status_pembayaran == 'belum')
                                <span class="badge red">Belum Bayar</span>
                            @elseif($d->status_pembayaran == 'menunggu')
                                <span class="badge orange">Menunggu</span>
                            @else
                                <span class="badge green">Lunas</span>
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
