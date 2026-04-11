@extends('user.layouts.app')

@section('content')
<style>
    .top-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-input {
        flex: 1;
        padding: 10px 15px;
        border-radius: 20px;
        border: 1px solid #ccc;
        width:45%;
        margin-top:20px;
    }

  /* KATEGORI */
.kategori-bar {
    display: flex;
    gap: 6px; /* lebih rapat */
    overflow-x: auto;
    margin-bottom: 15px;
}

/* ITEM */
.kategori-item {
    padding: 5px 12px; /* lebih kecil */
    background: #fff;
    border-radius: 999px; /* biar pill */
    border: 1px solid #ddd;
    white-space: nowrap;
    text-decoration: none;
    color: #374151;
    font-size: 12px; /* kecilin teks */
    font-weight: 500;
    transition: 0.2s;
}

/* HOVER & ACTIVE */
.kategori-item.active,
.kategori-item:hover {
    background: #2563eb;
    color: white;
}
    /* GRID */
    .book-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 24px;
        margin-bottom: 20px;
        margin-top:20px;
    }

    /* CARD */
    .book-item {
        background: #fff;
        padding: 14px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: 0.25s;
        position: relative;
    }

    .book-item:hover {
        transform: translateY(-6px);
    }

    /* COVER */
    .book-item img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        border-radius: 12px;
    }

    /* BADGE */
    .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(239, 68, 68, 0.95);
        color: white;
        font-size: 10px;
        padding: 4px 10px;
        border-radius: 20px;
        z-index: 2;
    }

    /* TEXT */
    .book-item h4 {
        font-size: 14px;
        margin-top: 10px;
        font-weight: 600;
    }

    .book-item p {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 10px;
    }

    /* BUTTON */
    .btn-group {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .btn-detail {
        background: #3b82f6;
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 8px;
    }

    .btn-pinjam {
        background: #22c55e;
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 8px;
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
        transition: 0.2s;
    }

    .pagination a:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }

    .pagination .active span {
        background: #2563eb;
        color: white;
    }

    .pagination .disabled span {
        opacity: 0.5;
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