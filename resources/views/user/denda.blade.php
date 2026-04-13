@extends('user.layouts.app')

@section('content')

<style>
.main-content {
    padding: 30px;
    background: linear-gradient(135deg, #f6efe7, #efe2d3);
    min-height: 100vh;
   
}

/* CARD */
.card-table {
    background: #fff7ea;
    border-radius: 18px;
    padding: 25px;
    border: 2px solid #d6b98c;
    box-shadow: 0 12px 30px rgba(80, 50, 20, 0.25);
    position: relative;
    overflow: hidden;
}

/* efek vintage grain */
.card-table::before {
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
    color: #fff;
    font-size: 13px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

th {
    padding: 15px;
    text-align: left;
   
}

/* BODY */
td {
    padding: 15px;
    font-size: 14px;
    color: #4b2e1e;
   
}

/* ROW STYLE */
tbody tr {
    border-bottom: 1px dashed #c9a77c;
    transition: 0.25s;
}

/* hover vintage */
tbody tr:hover {
    background: rgba(214, 185, 140, 0.25);
    transform: scale(1.01);
}

/* BADGE */
.badge {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 11px;
    color: #fff;
 
    letter-spacing: 0.5px;
}

.merah {
    background: #8b3a3a;
}

.hijau {
    background: #5c7a3a;
}

.orange {
    background: #b07a2a;
}

/* BUTTON */
.btn-bayar {
    background: linear-gradient(135deg, #7a4b2a, #4b2e1e);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.btn-bayar:hover {
    transform: translateY(-3px);
    background: #3b2418;
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 30px;
    color: #7a5c3e;
    font-style: italic;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
}

.modal-content {
    background: #fff7ea;
    width: 420px;
    max-width: 90%;
    margin: 7% auto;
    padding: 25px;
    border-radius: 18px;
    border: 2px solid #d6b98c;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* INPUT */
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #c9a77c;
    margin-top: 5px;
    background: #fffdf9;
    
}

/* MODAL ACTION */
.modal-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn-primary {
    flex: 1;
    background: #6b3f24;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 10px;
}

.btn-secondary {
    flex: 1;
    background: #e6d3b3;
    border: none;
    border-radius: 10px;
}
</style>

<div class="main-content">

    @if (session('success'))
        <div style="background:#e6fffa; padding:10px; border-radius:8px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background:#ffe4e6; padding:10px; border-radius:8px; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                    <th>Terlambat</th>
                    <th>Total Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($denda as $item)
                    <tr>
                        <td><strong>{{ $item->buku->judul ?? '-' }}</strong></td>
                        <td>
    {{ $item->jumlah ?? 1 }}
</td>
                     <td>{{ $item->terlambat }} Hari</td>
<td>Rp {{ number_format($item->total_denda ?? $item->denda_otomatis, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->status_pembayaran == 'belum')
                                <span class="badge merah">Belum</span>
                            @elseif($item->status_pembayaran == 'menunggu')
                                <span class="badge orange">Menunggu</span>
                            @else
                                <span class="badge hijau">Lunas</span>
                            @endif
                        </td>

                        <td>
    @if ($item->status_pembayaran == 'belum')
        <span style="color:black;">Bayar di petugas</span>
    @elseif($item->status_pembayaran == 'menunggu')
        <span style="color:#c68c2c;">Menunggu verifikasi</span>
    @else
        <span style="color:#6b8e23;">Lunas</span>
    @endif
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Tidak ada denda
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection