@extends('petugas.layouts.app')

@section('content')
    <style>
        .page-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #4b2e1e;
}

/* CARD TOTAL DENDA */
.denda-card {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 22px;
    border-radius: 18px;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(239,68,68,0.25);
    width: 45%;
}

.denda-card h3 {
    font-size: 14px;
    opacity: 0.9;
}

.denda-card h1 {
    font-size: 28px;
    margin-top: 5px;
}

/* TABLE BOX */
.table-box {
    background: #fff;
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 14px;
    background: #f3eae5;
    color: #6b3f24;
    font-weight: 600;
    font-size: 14px;
}

td {
    padding: 14px;
    font-size: 14px;
    border-bottom: 1px solid #f1f1f1;
}

tr:hover {
    background: #faf6f3;
    transition: 0.2s;
}

/* BADGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    color: #fff;
}

.orange { background: #f59e0b; }
.green { background: #10b981; }
.red { background: #ef4444; }

/* BUTTON */
.btn {
    padding: 6px 12px;
    border-radius: 999px;
    border: none;
    font-size: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
}

/* GROUP BUTTON */
.action-group {
    display: flex;
    gap: 6px;
}

/* IMAGE */
.img-preview {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.img-preview:hover {
    transform: scale(1.1);
}

/* MODAL IMAGE */
.modal-img {
    display: none;
    position: fixed;
    z-index: 999;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
}

.modal-img img {
    display: block;
    max-width: 90%;
    max-height: 80%;
    margin: 5% auto;
    border-radius: 12px;
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}
    </style>

    <h4 class="page-title">Kelola Denda</h4>

    <div class="denda-card">
        <h3>Total Denda Aktif</h3>
        <h1>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h1>
    </div>

    <div class="table-box">
        <table width="100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Terlambat</th>
                    <th>Total</th>
                   
                    <th>Status</th>
                    <th>Aksi</th> 
                </tr>
            </thead>

            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->terlambat }} Hari</td>
                        <td>Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>

                        
                     

                        {{-- STATUS --}}
                        <td>
                            @if ($item->status_pembayaran == 'menunggu')
                                <span class="badge orange">Menunggu</span>
                            @elseif($item->status_pembayaran == 'lunas')
                                <span class="badge green">Lunas</span>
                            @else
                                <span class="badge red">Belum</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                       <td>
    @if ($item->status_pembayaran != 'lunas')
        <form action="{{ route('petugas.lunaskan', $item->id) }}" method="POST">
            @csrf
            <button class="btn green"
                onclick="return confirm('Tandai denda ini sudah dibayar?')">
                Bayar (Offline)
            </button>
        </form>
    @else
        <span style="color:#10b981;">✔ Lunas</span>
    @endif
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;">
                            Tidak ada data denda
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:10px; font-size:13px; color:#64748b;">
            Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
            dari {{ $data->total() }} data
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $data->links() }}
    </div>

    {{-- MODAL GAMBAR --}}
    <div id="modalImg" class="modal-img" onclick="this.style.display='none'">
        <img id="imgPreview">
    </div>

    <script>
        function showImage(src) {
            document.getElementById('modalImg').style.display = 'block';
            document.getElementById('imgPreview').src = src;
        }
    </script>
@endsection
