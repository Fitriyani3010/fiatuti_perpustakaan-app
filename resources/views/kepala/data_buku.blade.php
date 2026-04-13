@extends('kepala.layouts.app')

@section('content')

<style>
/* BACKGROUND VINTAGE */
body {
    font-family: Poppins, sans-serif;
    background: #e9e2d6;
}

/* CARD VINTAGE */
.card {
    background: #fffaf3;
    padding: 20px;
    border-radius: 14px;
    margin-bottom: 20px;
    border: 1px solid #e6d3b3;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.12);
}

/* TITLE */
.card h2 {
    color: #4b2e1e;
    margin: 0;
}

/* FILTER FORM */
form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* INPUT & SELECT */
input, select {
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #d8b58a;
    outline: none;
    background: #fffdf8;
    color: #4b2e1e;
}

/* BUTTON */
.btn {
    padding: 8px 15px;
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    opacity: 0.9;
}

/* GREEN BUTTON DETAIL */
.btn-green {
    background: #2f7a4f;
    color: white;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    background: #fffdf8;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
th {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    padding: 12px;
    border-bottom: 2px solid #d8b58a;
}

/* BODY */
td {
    padding: 10px;
    border-bottom: 1px solid #ead9c3;
    text-align: center;
    color: #4b2e1e;
}

/* HOVER ROW */
tr {
    transition: 0.25s ease;
}

tr:hover {
    background: #f7efe3;
}

/* LINK */
a {
    text-decoration: none;
}

/* IMAGE COVER */
img {
    border-radius: 6px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

/* PAGINATION */
.pagination {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 6px;
}

.pagination a,
.pagination span {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #d8b58a;
    text-decoration: none;
    color: #6b3f24;
    background: #fffaf3;
}

.pagination .active span {
    background: #6b3f24;
    color: white;
    border-color: #6b3f24;
}
</style>

<div class="container">

    <!-- TITLE -->
    <div class="card">
        <h2> Data Buku</h2>
    </div>

    <!-- FILTER -->
    <div class="card">
       <form method="GET" action="{{ route('kepala.data_buku') }}" style="display:flex; gap:10px;">
            <input type="text" name="search" placeholder="Cari judul..."
                value="{{ request('search') }}">

            <select name="kategori">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}"
    {{ request('kategori') == $k->id ? 'selected' : '' }}>
    {{ $k->nama }}
</option>
                @endforeach
            </select>

            <button class="btn">Filter</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card">
        <table>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            @foreach($dataBuku as $buku)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    <img src="{{ $buku->cover ? asset('storage/'.$buku->cover) : 'https://via.placeholder.com/60' }}"
                         style="width:50px; height:70px; object-fit:cover;">
                </td>

                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->tahun_terbit }}</td>
                <td>{{ $buku->kategori->nama ?? '-' }}</td>

                <td>{{ $buku->stok ?? 0 }}</td>

                <td>
                    <a href="{{ route('kepala.detail_buku', ['id' => $buku->id]) }}"
   class="btn btn-green">
    Detail
</a>
                </td>
            </tr>
            @endforeach

        </table>

        <!-- PAGINATION -->
        <div style="margin-top:15px;">
            {{ $dataBuku->links() }}
        </div>

    </div>

</div>

@endsection