@extends('petugas.layouts.app')

@section('content')
<style>
    .page-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #4b2e1e;
    }

    /* SEARCH DI LUAR CARD */
    .search-box {
        margin-bottom: 15px;
        display: flex;
        justify-content: flex-end;
    }

    .search-box input {
        padding: 10px 16px;
        border-radius: 999px;
        border: 1px solid #d6c2b5;
        outline: none;
        width: 260px;
        transition: 0.2s;
    }

    .search-box input:focus {
        border-color: #6b3f24;
        box-shadow: 0 0 0 3px rgba(107,63,36,0.15);
    }

 /* CARD */
.table-box {
    background: #fdf8f3;
    padding: 22px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(75, 46, 30, 0.15);
    border: 1px solid #e6d5c3;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Georgia', serif;
}

/* HEADER TABLE */
th {
    text-align: left;
    padding: 16px;
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff8f0;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d6c2b5;
}

/* DATA TABLE */
td {
    padding: 14px 16px;
    font-size: 14px;
    color: #4b2e1e;
    border-bottom: 1px dashed #e0cfc2;
}

/* STRIPED EFFECT */
tr:nth-child(even) {
    background: #f7efe8;
}

/* HOVER */
tr:hover {
    background: #f1e4d8;
    transition: 0.3s;
}

/* BADGE (lebih vintage) */
.badge {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 11px;
    color: white;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.waiting { background: #c08a3e; }     /* emas tua */
.borrowed { background: #4a6fa5; }    /* biru vintage */
.late { background: #a94438; }        /* merah bata */
.done { background: #6b8e23; }        /* olive */

/* BUTTON */
.btn {
    padding: 6px 14px;
    border-radius: 999px;
    border: none;
    font-size: 12px;
    cursor: pointer;
    font-family: 'Georgia', serif;
    transition: 0.3s;
}

.btn.green { background: #6b8e23; color: white; }
.btn.blue { background: #4a6fa5; color: white; }
.btn.red { background: #a94438; color: white; }

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(75, 46, 30, 0.25);
}

/* AKSI */
.action-group {
    display: flex;
    gap: 8px;
}

/* EMPTY STATE */
td[colspan] {
    padding: 25px;
    font-style: italic;
    color: #8b6f5a;
}

    .action-group {
        display: flex;
        gap: 6px;
    }

    /* PAGINATION */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 25px;
    }
</style>

<h4 class="page-title">Kelola Peminjaman</h4>

{{-- FILTER BOX (KAYA KODE LAMA) --}}
<div style="
    background:white;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
">

    <form method="GET" action="{{ url()->current() }}"
        style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

        {{-- SEARCH --}}
        <input type="text"
            name="search"
            id="search"
            value="{{ request('search') }}"
            placeholder="🔍 Cari nama / buku..."
            style="
                padding:10px 15px;
                border-radius:10px;
                border:1px solid #d6c2b5;
                width:250px;
                outline:none;
            ">

        {{-- STATUS --}}
        <select name="status"
            style="
                padding:10px;
                border-radius:10px;
                border:1px solid #d6c2b5;
            ">
            <option value="">Semua Status</option>
            <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="dipinjam" {{ request('status')=='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status')=='dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>

        {{-- BUTTON FILTER --}}
        <button type="submit"
            style="
                padding:10px 18px;
                background:#6b3f24;
                color:white;
                border:none;
                border-radius:10px;
                cursor:pointer;
            ">
            🔎 Filter
        </button>

        {{-- RESET --}}
        <a href="{{ url()->current() }}"
            style="
                padding:10px 18px;
                background:#ef4444;
                color:white;
                border-radius:10px;
                text-decoration:none;
            ">
            Reset
        </a>

    </form>
</div>


<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Buku</th>
                <th>Jumlah</th> {{-- TAMBAHAN --}}
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
                @php
                    $hari = $item->tanggal_pinjam
                        ? \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays(now())
                        : 0;
                    $terlambat = $item->status == 'dipinjam' && $hari > 7;
                @endphp

                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->jumlah ?? 1 }}</td> {{-- AMAN (kalau ga ada tetap 1) --}}
                    <td>
                        {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                    </td>
                    <td>
                        @if ($item->status == 'menunggu')
                            <span class="badge waiting">Menunggu</span>
                        @elseif($item->status == 'dipinjam' && $terlambat)
                            <span class="badge late">Terlambat</span>
                        @elseif($item->status == 'dipinjam')
                            <span class="badge borrowed">Dipinjam</span>
                        @elseif($item->status == 'dikembalikan')
                            <span class="badge done">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            @if ($item->status == 'menunggu')
                                <form action="{{ route('petugas.peminjaman.approve', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn green" onclick="return confirm('Setujui?')">
                                        Setujui
                                    </button>
                                </form>
                            @endif

                            @if ($item->status == 'dipinjam')
                                <form action="{{ route('petugas.peminjaman.return', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn blue" onclick="return confirm('Sudah dikembalikan?')">
                                        Return
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- INFO --}}
    <div style="margin-top:10px; font-size:13px; color:#64748b;">
        Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
        dari {{ $data->total() }} data
    </div>
</div>

{{-- PAGINATION --}}
<div class="pagination-wrapper">
    {{ $data->links() }}
</div>


<script>
    let timeout = null;

    const searchInput = document.getElementById('search');

    searchInput.addEventListener('keyup', function() {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
</script>

@endsection