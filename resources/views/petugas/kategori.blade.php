@extends('petugas.layouts.app')

@section('content')
   <style>
  .page-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #4b2e1e;
  
}

/* WRAPPER */
.wrapper {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 20px;
}

/* CARD UMUM */
.card, .card1 {
    background: #fdf8f3; /* kertas tua */
    padding: 22px;
    border-radius: 20px;
    border: 1px solid #e6d5c3;
    box-shadow: 0 10px 30px rgba(75, 46, 30, 0.15);
    margin-bottom: 20px;
}

/* KHUSUS CARD INPUT */
.card1 {
    width: 50%;
}

/* HOVER */
.card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
}

/* TITLE */
.card h5,
.card1 h5 {
    margin-bottom: 15px;
    font-size: 16px;
    color: #6b3f24;
}

/* INPUT GROUP */
.input-group {
    display: flex;
    gap: 10px;
    width: 100%;
}

/* INPUT */
.input-group input {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #d6c2b5;
    background: #fffaf5;
    color: #4b2e1e;
    outline: none;
    transition: 0.2s;
}

.input-group input:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 0 3px rgba(107, 63, 36, 0.15);
}

/* BUTTON TAMBAH */
.input-group button {
    background: #6b8e23; /* olive */
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 999px;
    cursor: pointer;
    transition: 0.2s;
}

.input-group button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(75, 46, 30, 0.2);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
  
}

/* HEADER */
th {
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff8f0;
    padding: 14px;
    text-align: left;
    font-size: 13px;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d6c2b5;
}

/* DATA */
td {
    padding: 14px;
    font-size: 14px;
    color: #4b2e1e;
    border-bottom: 1px dashed #e0cfc2;
}

/* STRIPED */
tbody tr:nth-child(even) {
    background: #f7efe8;
}

/* HOVER */
tbody tr:hover {
    background: #f1e4d8;
    transition: 0.3s;
}

/* BUTTON DELETE */
.btn-delete {
    background: #a94438; /* merah bata */
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.2s;
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(75,46,30,0.2);
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 25px;
    color: #8b6f5a;
    font-style: italic;
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
