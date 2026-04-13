@extends('kepala.layouts.app')

@section('title', 'Laporan Anggota')

@section('content')

<style>
/* BACKGROUND VINTAGE */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #e9e2d6;
}

/* CARD VINTAGE */
.card {
    background: #fffaf3;
    padding: 22px;
    border-radius: 16px;
    margin-bottom: 20px;
    border: 1px solid #e6d3b3;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.12);
}

/* TITLE */
.card h2 {
    margin: 0;
    color: #4b2e1e;
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* TABLE */
.table-modern {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    background: #fffdf8;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
.table-modern th {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: #fff;
    padding: 14px;
    text-align: center;
    font-weight: 600;
    border-bottom: 2px solid #d8b58a;
}

/* BODY */
.table-modern td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ead9c3;
    color: #4b2e1e;
}

/* HOVER EFFECT */
.table-modern tr {
    transition: 0.25s ease;
}

.table-modern tr:hover {
    background: #f7efe3;
}

/* BADGE VINTAGE */
.badge {
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    color: #fff;
    font-weight: 600;
}

.green {
    background: #2f7a4f;
}

/* FILTER SECTION */
.filter-box {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

/* INPUT STYLE */
.input {
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #d8b58a;
    outline: none;
    width: 220px;
    background: #fffdf8;
    color: #4b2e1e;
}

/* BUTTON VINTAGE */
.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 999px;
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    opacity: 0.9;
}

/* PAGINATION */
.pagination {
    margin-top: 15px;
    text-align: center;
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
<!-- TITLE -->
    <div class="card">
        <h2> Data Anggota</h2>
    </div>
<div class="card">
    

    {{-- SEARCH + FILTER --}}
    <form method="GET" class="filter-box">

        <input type="text"
               name="search"
               class="input"
               placeholder="Cari nama / email..."
               value="{{ request('search') }}">

        <select name="kelas" class="input">
            <option value="">Semua Kelas</option>
            <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>X</option>
            <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
            <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
        </select>

        <button class="btn">Filter</button>

    </form>

    {{-- TABLE --}}
    <table class="table-modern">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>No HP</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
                <tr>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->email }}</td>
                    <td>{{ $d->nisn ?? '-' }}</td>
                    <td>{{ $d->kelas ?? '-' }}</td>
                    <td>{{ $d->no_telepon ?? '-' }}</td>
                    <td>
                        <span class="badge green">Aktif</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        Tidak ada data anggota
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- INFO --}}
    <div style="margin-top:10px; font-size:13px; color:#64748b;">
        Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
        dari {{ $data->total() }} data
    </div>

    {{-- PAGINATION --}}
    <div class="pagination">
        {{ $data->links() }}
    </div>

</div>

@endsection