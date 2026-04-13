@extends('user.layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<style>
.container {
    padding: 30px;
    background: linear-gradient(135deg, #f6efe7, #efe2d3);
    min-height: 100vh;
   
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 15px 20px;
    background: #fff7ea;
    border: 2px solid #d6b98c;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(80, 50, 20, 0.15);
}

.page-header h2 {
    font-size: 20px;
    font-weight: bold;
    color: #4b2e1e;
}

/* SEARCH */
.search-box input {
    padding: 10px 15px;
    border-radius: 10px;
    border: 1px solid #c9a77c;
    outline: none;
    background: #fffdf9;
   
    transition: 0.2s;
}

.search-box input:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 6px rgba(107, 63, 36, 0.3);
}

/* TABLE CARD */
.table-card {
    background: #fff7ea;
    border-radius: 18px;
    padding: 22px;
    border: 2px solid #d6b98c;
    box-shadow: 0 12px 30px rgba(80, 50, 20, 0.25);
    overflow: hidden;
    position: relative;
}

/* texture vintage */
.table-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: url("https://www.transparenttextures.com/patterns/paper-fibers.png");
    opacity: 0.25;
    pointer-events: none;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    position: relative;
    z-index: 1;
}

/* HEADER */
thead {
    background: linear-gradient(135deg, #6b3f24, #4b2e1e);
}

th {
    text-align: left;
    font-size: 12px;
    color: #fff;
    font-weight: bold;
    padding: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* BODY */
td {
    padding: 14px 12px;
    font-size: 14px;
    color: #4b2e1e;
}

/* ZEBRA */
tbody tr:nth-child(even) {
    background: rgba(214, 185, 140, 0.15);
}

/* HOVER */
tbody tr:hover {
    background: rgba(214, 185, 140, 0.35);
    transform: scale(1.01);
    transition: 0.2s;
}

/* STATUS */
.status {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: bold;
    letter-spacing: 0.5px;
    color: #fff;
}

.status.menunggu { background: #b07a2a; }
.status.dipinjam { background: #5c7a3a; }
.status.selesai { background: #3b5d3b; }
.status.terlambat { background: #8b3a3a; }

/* DENDA */
.denda {
    font-weight: bold;
    color: #8b3a3a;
}

/* BUTTON */
.btn-return {
    background: linear-gradient(135deg, #7a4b2a, #4b2e1e);
    color: white;
    border: none;
    padding: 7px 14px;
    border-radius: 10px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-return:hover {
    transform: translateY(-2px);
    background: #3b2418;
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
    border: 1px solid #c9a77c;
    background: #fff7ea;
    color: #4b2e1e;
    text-decoration: none;
    font-size: 13px;
    font-family: 'Georgia', serif;
}

.pagination a:hover {
    background: #6b3f24;
    color: white;
}

.pagination .active span {
    background: #6b3f24;
    color: white;
}

.pagination .disabled span {
    opacity: 0.5;
}

/* EMPTY ROW */
td[colspan] {
    text-align: center;
    padding: 25px;
    font-style: italic;
    color: #7a5c3e;
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
                    <th>Jumlah</th>
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
    {{ $item->jumlah ?? 1 }}
</td>

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
                            @if ($item->total_denda > 0)
                                <span class="denda">
                                     Rp {{ number_format($item->total_denda, 0, ',', '.') }}
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

