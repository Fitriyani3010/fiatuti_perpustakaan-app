@extends('user.layouts.app')

@section('title', 'Detail Buku')

@section('content')

<style>
.detail-container {
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
}

/* COVER */
.cover {
    width: 220px;
    height: 300px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* DETAIL */
.detail-info {
    flex: 1;
    max-width: 600px; /* 🔥 BATAS BIAR GA MELEBAR */
}

.label {
    color: #6b7280;
    font-size: 14px;
}

/* BADGE */
.badge {
    display: inline-block;
    background: #22c55e;
    color: white;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    margin: 10px 0;
}

.badge.red {
    background: #ef4444;
}

/* BUTTON */
.btn {
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    margin: 10px 5px 10px 0;
}

.btn-pinjam {
    background: #2563eb;
    color: white;
}

.btn-return {
    background: #f59e0b;
    color: white;
}

.btn-pinjam:hover {
    background: #1d4ed8;
}

.btn-return:hover {
    background: #d97706;
}

/* INPUT */
.input-jumlah {
    width: 70px;
    padding: 6px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* 🔥 DESKRIPSI FIX */
.deskripsi {
    margin-top: 10px;
    line-height: 1.6;
    color: #374151;

    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;

    background: #f9fafb;
    padding: 10px;
    border-radius: 8px;
}

/* REKOMENDASI */
.rekomendasi {
    margin-top: 20px;
}

.rekomendasi-list {
    display: flex;
    gap: 15px;
}

.rekomendasi-item {
    width: 150px;
    background: #fff;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    text-decoration: none;
}

.rekomendasi-item img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
}
</style>

<div class="detail-container">
    <div class="cover">
        <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/200' }}">
    </div>

    <div class="detail-info">
        <h2>{{ $buku->judul }}</h2>
        <p class="label">Pengarang: {{ $buku->penulis }}</p>
        <p class="label">Tahun: {{ $buku->tahun_terbit ?? '-' }}</p>
        <p class="label">Kategori: {{ $buku->kategori->nama ?? '-' }}</p>

        <div class="badge {{ $buku->stok <= 0 ? 'red' : '' }}">
            {{ $buku->stok > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
        </div>

        {{-- STATUS PINJAMAN --}}
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

                <input type="number" name="jumlah"
                       class="input-jumlah"
                       min="1"
                       max="{{ min(5, $buku->stok) }}"
                       value="1">

                <button class="btn btn-pinjam">Pinjam Buku</button>
            </form>
        @endif

        {{-- MENUNGGU --}}
        @if ($pinjaman && $pinjaman->status == 'menunggu')
            <span class="badge">Menunggu Persetujuan</span>
        @endif

        {{-- RETURN --}}
        @if ($pinjaman && $pinjaman->status == 'dipinjam')
            <form action="{{ route('user.return', $pinjaman->id) }}" method="POST">
                @csrf
                <button class="btn btn-return">Return Buku</button>
            </form>
        @endif

        {{-- 🔥 DESKRIPSI FIX --}}
        <p class="deskripsi">
            {{ $buku->deskripsi ?? 'Tidak ada deskripsi' }}
        </p>
    </div>
</div>

<div class="rekomendasi">
    <h4>Rekomendasi Buku Lainnya</h4>
    <div class="rekomendasi-list">
        @foreach ($rekomendasi as $item)
            <a href="{{ route('user.buku.detail', $item->id) }}" class="rekomendasi-item">
                <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/150' }}">
                <p>{{ $item->judul }}</p>
            </a>
        @endforeach
    </div>
</div>

@endsection