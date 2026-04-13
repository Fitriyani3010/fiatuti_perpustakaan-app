@extends('user.layouts.app')

@section('title', 'Detail Buku')

@section('content')

    <style>
     /* BACKGROUND */
body {
    background: #f4efe7;
    
}

/* CONTAINER */
.detail-wrapper {
    background: #fdfaf6;
    padding: 30px;
    border-radius: 18px;
    border: 1px solid #e6d3c5;
    box-shadow: 0 10px 30px rgba(101, 67, 33, 0.15);
    width:65%;
}

/* FLEX */
.detail-container {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

/* COVER */
.cover {
    width: 220px;
    height: 300px;
    border-radius: 12px;
    overflow: hidden;
    border: 4px solid #d6c2b5;
    box-shadow: 0 10px 25px rgba(101, 67, 33, 0.2);
}

.cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* INFO */
.detail-info {
    flex: 1;
    min-width: 250px;
}

.detail-info h2 {
    font-size: 26px;
    color: #4b2e1e;
    margin-bottom: 10px;
}

/* LABEL */
.label {
    color: #7a5c4d;
    font-size: 14px;
    margin-bottom: 6px;
}

/* BADGE */
.badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    margin: 10px 0;
    font-weight: 600;
}

.badge.green {
    background: #6b8e23;
    color: #fff;
}

.badge.red {
    background: #8b0000;
    color: #fff;
}

.badge.gray {
    background: #d6c2b5;
    color: #4b2e1e;
}

/* BUTTON */
.btn {
    border: none;
    padding: 10px 18px;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 10px;
    font-weight: 600;
    transition: 0.2s;

}

/* PINJAM */
.btn-pinjam {
    background: linear-gradient(135deg, #8b5e3c, #5c3a21);
    color: white;
}

.btn-pinjam:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(92, 58, 33, 0.4);
}

/* RETURN */
.btn-return {
    background: linear-gradient(135deg, #c19a6b, #8b5e3c);
    color: white;
}

.btn-return:hover {
    transform: translateY(-2px);
}

/* INPUT */
.input-jumlah {
    width: 70px;
    padding: 7px;
    border-radius: 8px;
    border: 1px solid #cbb7a7;
    margin-right: 8px;
    background: #fffaf3;
}

/* DESKRIPSI */
.deskripsi {
    margin-top: 20px;
    line-height: 1.8;
    color: #4b2e1e;
    background: #f8f1e7;
    padding: 18px;
    border-radius: 12px;
    border-left: 5px solid #8b5e3c;
    font-size: 14px;
}
.btn-kembali {
    display: inline-block;
    margin-top: 20px;
    padding: 8px 16px;
    background: transparent;
    border: 1px solid #8b5e3c;
    color: #5c3a21;
    border-radius: 8px;
    font-size: 14px;
   
    transition: 0.2s;
    text-decoration: none !important; /* 🔥 penting */
}

/* semua state */
.btn-kembali,
.btn-kembali:link,
.btn-kembali:visited,
.btn-kembali:hover,
.btn-kembali:active {
    text-decoration: none !important;
}

.btn-kembali:hover {
    background: #8b5e3c;
    color: #fff;
    transform: translateY(-1px);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .detail-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .cover {
        width: 180px;
        height: 260px;
    }
    /* BUTTON KEMBALI */
/* BUTTON KEMBALI */

}
    </style>
    <div class="detail-wrapper">
        <div class="detail-container">
            {{-- COVER --}}
            <div class="cover">
                <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/200' }}">
            </div>
            {{-- INFO --}}
            <div class="detail-info">
                <h2>{{ $buku->judul }}</h2>
                <p class="label">Pengarang: {{ $buku->penulis }}</p>
                <p class="label">Tahun: {{ $buku->tahun_terbit ?? '-' }}</p>
                <p class="label">Kategori: {{ $buku->kategori->nama ?? '-' }}</p>
                <div class="badge {{ $buku->stok > 0 ? 'green' : 'red' }}">
                    {{ $buku->stok > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                </div>
                {{-- PINJAMAN --}}
                @php
                    $pinjaman = \App\Models\Peminjaman::where('user_id', auth()->id())
                        ->where('buku_id', $buku->id)
                        ->whereIn('status', ['menunggu', 'dipinjam'])
                        ->first();
                @endphp
                {{-- PINJAM --}}
                @if (!$pinjaman && $buku->stok > 0)
                   <form action="{{ route('user.pinjam', $buku->id) }}" method="POST">
    @csrf

    {{-- STOK DITAMPILKAN DI ATAS INPUT --}}
    <p class="label" style="margin-bottom:8px;">
        Stok tersedia: <b>{{ $buku->stok }}</b>
    </p>

    <input type="number" name="jumlah" class="input-jumlah" min="1"
        max="{{ min(5, $buku->stok) }}" value="1">

    <button class="btn btn-pinjam">Pinjam Buku</button>
</form>
                @endif
                {{-- MENUNGGU --}}
                @if ($pinjaman && $pinjaman->status == 'menunggu')
                    <div class="badge gray">Menunggu Persetujuan</div>
                @endif
                {{-- RETURN --}}
                @if ($pinjaman && $pinjaman->status == 'dipinjam')
                    <form action="{{ route('user.return', $pinjaman->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-return">Return Buku</button>
                    </form>
                @endif
                {{-- DESKRIPSI --}}
                <div class="deskripsi">
                    {{ $buku->deskripsi ?? 'Tidak ada deskripsi' }}
                </div>
            </div>
        </div>
       <a href="{{ route('user.library') }}" class="btn-kembali">
    ← Kembali
</a>
    </div>
@endsection
