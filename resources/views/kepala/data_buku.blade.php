@extends('kepala.layouts.app')

@section('content')

<style>
    body {
        font-family: Poppins, sans-serif;
        background:#eae6e3;
    }

    .card {
        background:white;
        padding:20px;
        border-radius:10px;
        margin-bottom:20px;
    }

    .btn {
        padding:8px 15px;
        background:#6b3f24;
        color:white;
        border:none;
        border-radius:5px;
        cursor:pointer;
    }

    .btn-green { background:#28a745; }

    table {
        width:100%;
        border-collapse:collapse;
        table-layout: fixed;
    }

    th {
        background:#6b3f24;
        color:white;
        padding:12px;
    }

    td {
        padding:10px;
        border-bottom:1px solid #ddd;
        text-align:center;
    }

    tr:hover {
        background:#f5f5f5;
    }
    a {
    text-decoration: none;
}
.search {
        padding:10px 16px;
        border-radius:999px;
        border:1px solid #ddd;
        width:250px;
        outline:none;
    }
</style>

<div class="container">

    <!-- TITLE -->
    <div class="card">
        <h2>📚 Data Buku</h2>
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