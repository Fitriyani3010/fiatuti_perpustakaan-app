@extends('user.layouts.app')

@section('content')

<style>
.main-content {
    padding: 25px;
    background: #f5efe6;
    min-height: 100vh;
   
}

/* TABLE CARD (VINTAGE) */
.card-table {
    background: #fffaf3;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #e6d3b3;
    box-shadow: 0 6px 18px rgba(101, 67, 33, 0.15);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

/* HEADER */
thead {
    background: #6b3f24;
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

th {
    padding: 14px;
    text-align: left;
}

/* BODY */
td {
    padding: 14px;
    font-size: 14px;
    color: #4b2e1e;
}

/* GARIS HALUS */
tbody tr {
    border-bottom: 1px dashed #d6c2a8;
}

/* HOVER */
tbody tr:hover {
    background: #f3e8d9;
    transition: 0.2s;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    color: white;
    font-family: 'Poppins', sans-serif;
}

.merah { background: #a94442; }
.hijau { background: #6b8e23; }
.orange { background: #c68c2c; }

/* BUTTON */
.btn-bayar {
    background: linear-gradient(135deg, #8b5e3c, #5c3a21);
    color: white;
    border: none;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-bayar:hover {
    transform: translateY(-2px);
    background: #4b2e1e;
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 20px;
    color: #7a5c3e;
}

/* MODAL (VINTAGE) */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background: #fffaf3;
    width: 420px;
    max-width: 90%;
    margin: 6% auto;
    padding: 25px;
    border-radius: 16px;
    border: 1px solid #e6d3b3;
}

.modal-close {
    float: right;
    cursor: pointer;
}

/* INPUT */
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d6c2a8;
    margin-top: 5px;
    background: #fff;
}

/* BUTTON MODAL */
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
    border-radius: 8px;
}

.btn-secondary {
    flex: 1;
    background: #e6d3b3;
    border: none;
    border-radius: 8px;
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
                       @php
                            $terlambat = 0;

                            if ($item->tenggat_waktu) {
                                $selisih = \Carbon\Carbon::parse($item->tenggat_waktu)->diffInDays(now(), false);

                                if ($selisih > 0) {
                                    $terlambat = $selisih;
                                }
                            }
                        @endphp

<td>{{ $terlambat }} Hari</td>
                        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>

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