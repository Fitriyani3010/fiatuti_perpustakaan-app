@extends('kepala.layouts.app')

@section('title', 'Laporan Anggota')

@section('content')

<style>
    body {
        margin:0;
        font-family:Poppins, sans-serif;
        background:#eae6e3;
    }

    .card {
        background:white;
        padding:20px;
        border-radius:12px;
        margin-bottom:20px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
    }

    .table-modern {
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
    }

    .table-modern th {
        background:#6b3f24;
        color:white;
        padding:12px;
        text-align:center;
    }

    .table-modern td {
        padding:12px;
        text-align:center;
        border-bottom:1px solid #eee;
    }

    .table-modern tr:hover {
        background:#f5f5f5;
    }

    .badge {
        padding:4px 10px;
        border-radius:20px;
        font-size:12px;
        color:white;
    }

    .green {
        background:#28a745;
    }

    .pagination {
        margin-top:15px;
        text-align:center;
    }

    /* SEARCH + FILTER */
    .filter-box {
        display:flex;
        gap:10px;
        margin-bottom:15px;
        flex-wrap:wrap;
    }

    .input {
        padding:10px 14px;
        border-radius:999px;
        border:1px solid #ddd;
        outline:none;
        width:220px;
    }

    .btn {
        padding:10px 16px;
        border:none;
        border-radius:999px;
        background:#6b3f24;
        color:white;
        cursor:pointer;
    }
</style>
<!-- TITLE -->
    <div class="card">
        <h2>👥 Data Anggota</h2>
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