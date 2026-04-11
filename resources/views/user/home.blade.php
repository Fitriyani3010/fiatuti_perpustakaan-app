@extends('user.layouts.app')

@section('title', 'Home — Perpustakaan Digital')

@push('styles')
<style>
/* CONTAINER */
.content-box {
    background: #e5e5e5;
    padding: 20px;
    border-radius: 16px;
}

/* STAT */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

.stat-card {
    border-radius: 16px;
    padding: 20px;
    color: white;
    transition: 0.3s;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-6px);
}

/* WARNA */
.stat-card.green { background: #4CAF50; }
.stat-card.green:hover { background: linear-gradient(45deg,#4CAF50,#2ecc71); }

.stat-card.yellow { background: #f4b942; }
.stat-card.yellow:hover { background: linear-gradient(45deg,#f4b942,#f39c12); }

.stat-card.blue { background: #3498db; }
.stat-card.blue:hover { background: linear-gradient(45deg,#3498db,#5dade2); }

.stat-card.red { background: #e74c3c; }
.stat-card.red:hover { background: linear-gradient(45deg,#e74c3c,#ff6b6b); }

.stat-num {
    font-size: 24px;
    font-weight: 700;
}

.stat-lbl {
    font-size: 13px;
    margin-top: 5px;
}

/* SECTION */
.sec-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #000;
}

/* GRID BUKU */
.buku-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 20px;
}

/* CARD BUKU */
.buku-card {
    background: #f9fafb;
    border-radius: 16px;
    padding: 12px;
    text-align: center;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
     text-decoration: none; /* 🔥 HILANGIN GARIS */
    color: inherit;
}

.buku-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
         text-decoration: none; /* 🔥 HILANGIN GARIS */
}

/* COVER */
.buku-cover {
    height: 140px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
}

.buku-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* INFO */
.buku-judul {
    font-size: 14px;
    font-weight: 600;
      margin-top: 5px;
}

.buku-penulis {
    font-size: 12px;
    color: #777;
margin-bottom: 6px;
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
    background: #6b3f24;
    color: white;
}

.pagination .active span {
    background: #6b3f24;
    color: white;
}
</style>
@endpush

@section('content')

<div style="
    background: #6b3f24;
    color: white;
    padding: 25px 20px; /* tadinya 15px jadi lebih tinggi */
    border-radius: 16px;
    margin-bottom: 20px;
">
    <div style="font-size:16px; font-weight:600;">
        👋 Selamat datang, {{ auth()->user()->name }}
    </div>
    <div style="font-size:13px; opacity:0.9; margin-top:3px;">
        Selamat membaca dan temukan buku favoritmu hari ini 📚
    </div>
</div>

<div class="content-box">

    {{-- STAT --}}
    <div class="stat-grid">

        <div class="stat-card green">
            <div class="stat-num">📚 {{ $totalBuku }}</div>
            <div class="stat-lbl">Buku</div>
        </div>

        <div class="stat-card yellow">
            <div class="stat-num">📖 {{ $totalPeminjaman }}</div>
            <div class="stat-lbl">Dipinjam</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-num">📦 {{ $totalPeminjaman }}</div>
            <div class="stat-lbl">Dikembalikan</div>
        </div>

        <div class="stat-card red">
            <div class="stat-num">⚠️ {{ $dendaAktif }}</div>
            <div class="stat-lbl">Denda</div>
        </div>

    </div>

    {{-- BUKU --}}
    <div class="sec-title">📚 Buku Terbaru</div>

    <div class="buku-grid">
        @forelse ($bukuPopuler as $buku)
           <div class="buku-card" onclick="window.location='{{ route('user.buku.detail', $buku->id) }}'">

    <div class="buku-cover">
        @if ($buku->cover)
            <img src="{{ asset('storage/' . $buku->cover) }}">
        @else
            <div style="padding-top:40px; font-size:12px;">
                No Cover
            </div>
        @endif
    </div>

    <div class="buku-judul">{{ $buku->judul }}</div>
    <div class="buku-penulis">{{ $buku->penulis }}</div>

    {{-- BUTTON PINJAM --}}
    <a href="{{ route('user.buku.detail', $buku->id) }}"
       onclick="event.stopPropagation()"
       style="
            display:inline-block;
            margin-top:10px;
            padding:6px 12px;
            background:#22c55e;
            color:white;
            font-size:12px;
            border-radius:8px;
            text-decoration:none;
            font-weight:600;
       "
       onmouseover="this.style.background='#16a34a'"
       onmouseout="this.style.background='#22c55e'">
        📥 Pinjam
    </a>

</div>
        @empty
            <div style="grid-column:1/-1;text-align:center;color:#9CA3AF;">
                Tidak ada buku
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        {{ $bukuPopuler->links() }}
    </div>

</div>

@endsection