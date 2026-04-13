@extends('user.layouts.app')

@section('content')
<style>
/* CONTAINER VINTAGE */
.container {
    background: #f5efe6;
    padding: 25px;
    border-radius: 18px;
    border: 1px solid #e6d3b3;
    box-shadow: inset 0 0 0 1px #fff, 0 10px 25px rgba(101,67,33,0.15);
 
}

/* TITLE */
h2 {
    color: #5a3b24;
    font-weight: bold;
    border-left: 5px solid #8b5e3c;
    padding-left: 10px;
    margin-bottom: 15px;
}

/* SEARCH BAR */
.top-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

/* INPUT */
.search-input,
.kategori-select {
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #d6c2a8;
    background: #fffaf3;
   
    color: #4b2e1e;
}

/* BUTTON */
.btn-cari {
    padding: 10px 16px;
    border-radius: 12px;
    border: none;
    background: #8b5e3c;
    color: white;
    cursor: pointer;
    transition: 0.2s;
    font-weight: 600;
}

.btn-cari:hover {
    background: #5c3a21;
}

/* INFO TEXT */
p {
    color: #7a5c3e;
    font-size: 13px;
}

/* GRID */
.book-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 24px;
    margin-top: 20px;
}

/* BOOK CARD */
.book-item {
    background: #fffaf3;
    padding: 14px;
    border-radius: 16px;
    box-shadow: 0 6px 15px rgba(101,67,33,0.15);
    border: 1px solid #e6d3b3;
    text-align: center;
    text-decoration: none;
    color: #4b2e1e;
    transition: 0.3s;
    position: relative;
}

.book-item:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(101,67,33,0.25);
}

/* COVER */
.book-item img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #e6d3b3;
}

/* BADGE KATEGORI */
.badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #8b5e3c;
    color: white;
    font-size: 10px;
    padding: 4px 10px;
    border-radius: 20px;
}

/* TEXT */
.book-item h4 {
    font-size: 14px;
    margin-top: 10px;
    font-weight: bold;
}

.book-item p {
    font-size: 12px;
    color: #7a5c3e;
}

/* BUTTON GROUP */
.btn-group {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

/* PINJAM BUTTON */
.btn-pinjam {
    background: #3cc53a;
    color: white;
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-pinjam:hover {
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

<div class="container">
    <h2>Daftar Buku</h2>

    {{-- SEARCH --}}
    <form method="GET" class="top-bar">
    
    <!-- SEARCH -->
    <input type="text" 
        name="search" 
        class="search-input" 
        placeholder="Cari buku..." 
        value="{{ request('search') }}">

    <!-- FILTER KATEGORI -->
    <select name="kategori" class="kategori-select">
        <option value="">Kategori</option>
        @foreach ($kategoris as $k)
            <option value="{{ $k->id }}" 
                {{ request('kategori') == $k->id ? 'selected' : '' }}>
                {{ $k->nama }}
            </option>
        @endforeach
    </select>

    <!-- BUTTON -->
    <button type="submit" class="btn-cari">Cari</button>

</form>
<p>Menampilkan {{ $books->count() }} dari {{ $books->total() }} buku</p>
      

    {{-- LIST BUKU --}}
    <div class="book-list">
        @forelse($books as $book)
            <a href="{{ route('user.buku.detail', $book->id) }}" class="book-item">

                @if ($book->kategori)
                    <div class="badge">{{ $book->kategori->nama }}</div>
                @endif

                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/150' }}">

                <h4>{{ \Illuminate\Support\Str::limit($book->judul, 25) }}</h4>
                <p>{{ $book->penulis }}</p>

                <div class="btn-group">
                   
                    <span class="btn-pinjam">Pinjam</span>
                </div>

            </a>
        @empty
            <p style="text-align:center; grid-column:1/-1;">
                Tidak ada buku ditemukan
            </p>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        {{ $books->links() }}
    </div>

</div>
@endsection