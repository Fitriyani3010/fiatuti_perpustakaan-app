@extends('user.layouts.app')

@section('title', 'Home — Perpustakaan Digital')

@push('styles')
<style>
/* CONTAINER VINTAGE */
.content-box {
    background: #f5efe6;
    padding: 22px;
    border-radius: 18px;
    border: 1px solid #e6d3b3;
    box-shadow: inset 0 0 0 1px #fff, 0 8px 20px rgba(101,67,33,0.15);
 
}

/* HEADER WELCOME */
.content-box > div:first-child {
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* STAT GRID */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

/* STAT CARD VINTAGE */
.stat-card {
    border-radius: 16px;
    padding: 20px;
    color: #fff;
    transition: 0.3s;
    cursor: pointer;
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    border: 1px solid rgba(255,255,255,0.2);
}

/* HOVER */
.stat-card:hover {
    transform: translateY(-6px);
    filter: brightness(1.05);
}

/* VINTAGE COLOR PALETTE */
.stat-card.green {
    background: linear-gradient(135deg, #5c8d4d, #3e6b35);
}

.stat-card.yellow {
    background: linear-gradient(135deg, #c49a3a, #a6781f);
}

.stat-card.blue {
    background: linear-gradient(135deg, #4a7a9e, #2f5d7c);
}

.stat-card.red {
    background: linear-gradient(135deg, #a14b3b, #7a2f24);
}

/* TEXT */
.stat-num {
    font-size: 22px;
    font-weight: bold;

}

.stat-lbl {
    font-size: 13px;
    opacity: 0.9;
}

/* SECTION TITLE */
.sec-title {
    font-size: 18px;
    font-weight: bold;
    color: #5a3b24;
    margin-bottom: 15px;
    border-left: 4px solid #8b5e3c;
    padding-left: 10px;
}

/* GRID BUKU */
.buku-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 20px;
}

/* CARD BUKU VINTAGE */
.buku-card {
    background: #fffaf3;
    border-radius: 16px;
    padding: 12px;
    text-align: center;
    transition: 0.3s;
    box-shadow: 0 6px 15px rgba(101,67,33,0.15);
    border: 1px solid #e6d3b3;
    text-decoration: none;
    color: #4b2e1e;
   
}

.buku-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(101,67,33,0.25);
}

/* COVER */
.buku-cover {
    height: 140px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
    border: 1px solid #e6d3b3;
}

.buku-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* TEXT */
.buku-judul {
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    color: #4b2e1e;
}

.buku-penulis {
    font-size: 12px;
    color: #7a5c3e;
    margin-bottom: 6px;
}

/* BUTTON */
.buku-card a {
    display: inline-block;
    margin-top: 10px;
    padding: 6px 12px;
    background: #8b5e3c;
    color: white;
    font-size: 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.2s;
}

.buku-card a:hover {
    background: #5c3a21;
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

.pagination a,
.pagination span {
    border-radius: 10px;
    border: 1px solid #e6d3b3;
    background: #fffaf3;
    color: #5a3b24;
    padding: 8px 12px;
}

.pagination a:hover {
    background: #8b5e3c;
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
        Temukan buku favoritmu hari ini 
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
         Pinjam
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