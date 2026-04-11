@extends('user.layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<style>
.container {
    padding: 20px;
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-header h2 {
    font-size: 20px;
    font-weight: 600;
}

/* SEARCH */
.search-box input {
    padding: 10px 15px;
    border-radius: 20px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.2s;
}

.search-box input:focus {
    border-color: #2563eb;
}

/* TABLE CARD */
.table-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    overflow: hidden;
    
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

/* HEADER */
thead {
    background: #c1795b;
}

th {
    text-align: left;
    font-size: 12px;
    color: #f9fafc;
    font-weight: 600;
    padding: 12px;
}

/* BODY */
td {
    padding: 14px 12px;
    font-size: 13px;
}

/* ZEBRA EFFECT */
tbody tr:nth-child(even) {
    background: #fafafa;
}

/* HOVER EFFECT */
tbody tr:hover {
    background: #f1f5f9;
    transition: 0.2s;
}

/* GARIS HALUS */
tr:not(:last-child) {
    border-bottom: 1px solid #f1f1f1;
}
/* STATUS */
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
}

.status.menunggu { background: #fff3cd; color: #856404; }
.status.dipinjam { background: #dbeafe; color: #2563eb; }
.status.selesai { background: #dcfce7; color: #16a34a; }
.status.terlambat { background: #fee2e2; color: #dc2626; }

/* DENDA */
.denda {
    font-weight: 600;
    color: #ef4444;
}

/* BUTTON */
.btn-return {
    background: #22c55e;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-return:hover {
    background: #16a34a;
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

.pagination {
    display: flex;
    gap: 8px;
}

.pagination li {
    list-style: none;
}

.pagination a,
.pagination span {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    text-decoration: none;
    font-size: 13px;
}

.pagination a:hover {
    background: #2563eb;
    color: white;
}

.pagination .active span {
    background: #2563eb;
    color: white;
}

.pagination .disabled span {
    opacity: 0.5;
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="page-header">
        <h2>📚 Riwayat Peminjaman</h2>

        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}">
            </form>
        </div>
    </div>

    <!-- CARD TABLE -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($riwayats as $item)
                    @php
                        $hari = $item->tanggal_pinjam
                            ? \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays(now())
                            : 0;
                        $terlambat = $item->status == 'dipinjam' && $hari > 1;
                    @endphp

                    <tr>
                        <td><strong>{{ $item->buku->judul ?? '-' }}</strong></td>

                        <td>
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            @if ($item->status == 'menunggu')
                                <span class="status menunggu">Menunggu</span>
                            @elseif($item->status == 'dipinjam' && $terlambat)
                                <span class="status terlambat">Terlambat</span>
                            @elseif($item->status == 'dipinjam')
                                <span class="status dipinjam">Dipinjam</span>
                            @elseif($item->status == 'dikembalikan')
                                <span class="status selesai">Selesai</span>
                            @endif
                        </td>

                        <td>
                            @if ($item->denda > 0)
                                <span class="denda">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if ($item->status == 'dipinjam')
                                <form action="{{ route('user.return', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-return"
                                        onclick="return confirm('Yakin ingin mengembalikan buku?')">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        {{ $riwayats->links() }}
    </div>

</div>


@endsection

