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

/* TABLE BOX (kertas tua) */
.table-box {
    background: #fdf8f3;
    padding: 22px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(75, 46, 30, 0.15);
    border: 1px solid #e6d5c3;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
   
}

/* HEADER TABLE */
th {
    text-align: left;
    padding: 16px;
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff8f0;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d6c2b5;
}

/* DATA */
td {
    padding: 14px 16px;
    font-size: 14px;
    color: #4b2e1e;
    border-bottom: 1px dashed #e0cfc2;
}

/* STRIPED ROW */
tr:nth-child(even) {
    background: #f7efe8;
}

/* HOVER */
tr:hover {
    background: #f1e4d8;
    transition: 0.3s;
}

.btn.green { background: #6b8e23; color: white; }
.btn.red { background: #a94438; color: white; }
.btn.blue { background: #4a6fa5; color: white; }

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(75, 46, 30, 0.25);
}

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
.denda-wrapper {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 250px;
    padding: 25px;
    border-radius: 18px;
    color: white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card h3 {
    font-size: 14px;
    opacity: 0.9;
}

.card h1 {
    font-size: 30px;
    margin-top: 5px;
}

/* WARNA */
.merah {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.hijau {
    background: linear-gradient(135deg, #10b981, #059669);
}
    </style>

    <h4 class="page-title">Kelola Denda</h4>

   <div class="denda-wrapper">

    <div class="card merah">
        <h3>Denda Belum Dibayar</h3>
        <h1>Rp {{ number_format($totalDendaAktif, 0, ',', '.') }}</h1>
    </div>

    <div class="card hijau">
        <h3>Denda Sudah Dibayar</h3>
        <h1>Rp {{ number_format($totalDendaLunas, 0, ',', '.') }}</h1>
    </div>

</div>
    <div class="table-box">
        <table width="100%">
            <thead>
                <tr>
                    
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Jumlah Pinjam</th>
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
                      <td>
    {{ $item->jumlah ?? 1 }}
</td>
                        <td>{{ $item->terlambat }} Hari</td>
<td>
  Rp {{ number_format((int)$item->total_denda, 0, ',', '.') }}
    @if ($item->total_denda > 0 && $item->status_pembayaran == 'lunas')
        <br><small style="color:#10b981;">✔ Sudah dibayar</small>
    @endif
</td>
                        
                     

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
    @if ($item->status == 'dikembalikan' && $item->total_denda > 0 && $item->status_pembayaran != 'lunas')
        <form action="{{ route('petugas.lunaskan', $item->id) }}" method="POST">
            @csrf
            <button class="btn green"
                onclick="return confirm('Tandai denda ini sudah dibayar?')">
                Bayar (Offline)
            </button>
        </form>

    @elseif ($item->status_pembayaran == 'lunas' && $item->total_denda > 0)
        <span style="color:#10b981;">✔ Lunas</span>

    @else
        <span style="color:#94a3b8;">-</span>
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
