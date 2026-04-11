@extends('petugas.layouts.app')

@section('content')
   <style>
   .page-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #374151;
}

/* GRID BIAR LAYOUT BAGUS */
.wrapper {
    display: grid;
    grid-template-columns: 1fr 2fr;
      gap: 30px; /* 🔥 ini yang bikin renggang */
    gap: 0;
}

/* CARD */
.card {
    background: #ffffff;
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
        border: 1px solid #f1f1f1;
        margin-bottom: 20px;
   
}

/* CARD */
.card1 {
    background: #ffffff;
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
    width:50%;
    margin-bottom: 20px;
}


.card:hover {
    transform: translateY(-2px);
}

/* TITLE CARD */
.card h5 {
    margin-bottom: 15px;
    font-size: 16px;
    color: #6b3f24;
}

/* INPUT */
.input-group {
    display: flex;
    gap: 10px;
    width: 50%;
}

.input-group input {
    flex: 1;
    padding: 12px;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
    outline: none;
    transition: 0.2s;
}

.input-group input:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 0 3px rgba(107, 63, 36, 0.1);
}

/* BUTTON TAMBAH */
.input-group button {
    background: #6b3f24;
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 999px;
    cursor: pointer;
    transition: 0.2s;
}

.input-group button:hover {
    background: #7a4a2a;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

/* HEADER */
th {
    background: #6b3f24;
    color: white;
    padding: 14px;
    text-align: left;
    font-size: 14px;
}

/* ISI */
td {
    padding: 14px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

/* ROW HOVER */
tbody tr {
    transition: 0.2s;
}

tbody tr:hover {
    background: #f9f6f3;
}

/* BUTTON DELETE */
.btn-delete {
    background: #ef4444;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.2s;
}

.btn-delete:hover {
    background: #dc2626;
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 25px;
    color: #9ca3af;
}
</style>
    <h4 class="page-title">Kelola Kategori</h4>
    {{-- FORM TAMBAH --}}
    <div class="card1">
        <h5>Tambah Kategori</h5>
        <form method="POST" action="{{ route('petugas.kategori.store') }}">
            @csrf
            <div class="input-group">
                <input type="text" name="nama" placeholder="Masukkan nama kategori..." required>
                <button type="submit">Tambah</button>
            </div>
        </form>
    </div>
    {{-- DATA --}}
    <div class="card">
        <h5>Data Kategori</h5>
        <table>
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $k)
                    <tr>
                        <td>{{ $k->nama }}</td>
                        <td>
                            <form action="{{ route('petugas.kategori.delete', $k->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete" onclick="return confirm('Hapus kategori ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="empty">
                            Belum ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
