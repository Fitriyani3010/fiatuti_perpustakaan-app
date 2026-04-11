@extends('petugas.layouts.app')

@section('title', 'Kelola Buku')

@section('content')

    <style>
       body {
    background: #eae6e3;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 22px;
    font-weight: 700;
}

/* SEARCH */
.actions {
    display: flex;
    gap: 10px;
}

.actions input {
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
}

/* BUTTON */
.btn {
    background: #4CAF50;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    transform: translateY(-2px);
}

/* ALERT */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* CARD TABLE */
.table-box {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    overflow-x: auto;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    font-size: 14px;
}

/* HEADER TABLE */
th {
    background: #d6c2b5;
    color: #333;
    padding: 12px;
    font-weight: 600;
}

/* ISI TABLE */
td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

/* HOVER */
tbody tr:hover {
    background: #f9f6f3;
}

/* COVER */
td img {
    width: 45px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

/* AKSI */
.action-group {
    display: flex;
    justify-content: center;
    gap: 6px;
}

/* BUTTON AKSI */
.edit {
    background: #3498db;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
}

.hapus {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
}

/* FORCE FIX PAGINATION */
.pagination {
    display: flex !important;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 0;
    margin: 20px 0;
}

.pagination li {
    list-style: none !important;
    display: inline-block;
}

.pagination li a,
.pagination li span {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: 8px;
    border: 1px solid #d6c2b5;
    background: #fff;
    color: #6b3f24;
    font-size: 13px;
    text-decoration: none;
}

.pagination li a:hover {
    background: #6b3f24;
    color: #fff;
}

.pagination .active span {
    background: #6b3f24;
    color: white;
    border-color: #6b3f24;
}

.pagination .disabled span {
    opacity: 0.4;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal form {
    background: white;
    padding: 25px;
    border-radius: 15px;
    width: 420px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    animation: fadeIn 0.3s;
}

.modal input,
.modal select,
.modal textarea {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
    </style>
    <div class="page-header">
        <h1>Kelola Buku</h1>
        {{-- search --}}
        <div class="actions">
            <form method="GET" action="{{ url()->current() }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
            </form>
            <button type="button" class="btn" onclick="openModal()">+ Tambah</button>
        </div>
    </div>

    @if (session('success'))
       <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($bukus as $b)
                    <tr>
                        <td>
                            @if ($b->cover)
                                <img src="{{ asset('storage/' . $b->cover) }}"
                                    style="width:40px;height:55px;border-radius:6px;object-fit:cover;">
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->penulis }}</td>
                        <td>{{ $b->kategori->nama ?? '-' }}</td>
                        <td>{{ $b->stok }}</td>

                        <td>
                            <div class="action-group">
                                <button type="button" class="edit" onclick='editData(@json($b))'>
                                    Edit
                                </button>

                                <form action="{{ route('petugas.buku.delete', $b->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="hapus" onclick="return confirm('Hapus buku ini?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada data buku</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- INFO --}}
        <div style="margin-top:10px; font-size:13px; color:#64748b;">
            Menampilkan {{ $bukus->firstItem() ?? 0 }} - {{ $bukus->lastItem() ?? 0 }}
            dari {{ $bukus->total() }} data
        </div>
    </div>
    {{-- pagination --}}
    <div class="pagination">
        {{ $bukus->links() }}
    </div>
    {{-- MODAL --}}
    <div id="modal" class="modal">
        <form method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="method">
            <h3 id="title">Tambah Buku</h3>
            <input type="text" name="judul" id="judul" placeholder="Judul" required>
            <input type="text" name="penulis" id="penulis" placeholder="Penulis" required>
            <input type="text" name="penerbit" id="penerbit" placeholder="Penerbit">
            <input type="number" name="tahun_terbit" id="tahun_terbit" placeholder="Tahun Terbit">
            <select name="kategori_id" id="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>
            <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi"></textarea>
            <input type="number" name="stok" id="stok" placeholder="Stok" required>
            <input type="file" name="cover">
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn">Simpan</button>
                <button type="button" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('form').action = "{{ route('petugas.buku.store') }}";
            document.getElementById('method').value = '';
            document.getElementById('title').innerText = 'Tambah Buku';
            clearForm();
        }

        function editData(data) {
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('form').action = "/dashboard/petugas/buku/update/" + data.id;
            document.getElementById('method').value = 'PUT';
            document.getElementById('title').innerText = 'Edit Buku';
            document.getElementById('judul').value = data.judul;
            document.getElementById('penulis').value = data.penulis;
            document.getElementById('penerbit').value = data.penerbit ?? '';
            document.getElementById('tahun_terbit').value = data.tahun_terbit ?? '';
            document.getElementById('kategori_id').value = data.kategori_id;
            document.getElementById('deskripsi').value = data.deskripsi ?? '';
            document.getElementById('stok').value = data.stok;
        }

        function clearForm() {
            document.getElementById('judul').value = '';
            document.getElementById('penulis').value = '';
            document.getElementById('penerbit').value = '';
            document.getElementById('tahun_terbit').value = '';
            document.getElementById('kategori_id').value = '';
            document.getElementById('deskripsi').value = '';
            document.getElementById('stok').value = '';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        window.onclick = function(e) {
            let modal = document.getElementById('modal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endsection
