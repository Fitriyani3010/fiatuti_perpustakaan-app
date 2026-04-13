@extends('kepala.layouts.app')

@section('title', 'Kelola Petugas')

@section('content')

<style>
/* BACKGROUND VINTAGE */
body {
    margin: 0;
    font-family: Poppins, sans-serif;
    background: #e9e2d6;
}

a {
    text-decoration: none;
    color: inherit;
}

/* CONTENT WRAPPER */
.content {
    padding: 25px;
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

/* PAGE HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* SEARCH */
.search {
    padding: 10px 16px;
    border-radius: 10px;
    border: 1px solid #d8b58a;
    width: 250px;
    outline: none;
    background: #fffdf8;
    color: #4b2e1e;
}

/* BUTTONS VINTAGE */
.btn-add {
    background: linear-gradient(135deg, #6b3f24, #8b5a2b);
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-add:hover {
    opacity: 0.9;
}

.btn-green {
    background: #2f7a4f;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-edit {
    background: #c07a2c;
    color: white;
    padding: 6px 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.btn-delete {
    background: #b23a3a;
    color: white;
    padding: 6px 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
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
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ead9c3;
    color: #4b2e1e;
}

/* HOVER ROW */
tr {
    transition: 0.25s;
}

tr:hover {
    background: #f7efe3;
}

/* MODAL VINTAGE */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-content {
    background: #fffaf3;
    padding: 25px;
    border-radius: 14px;
    width: 380px;
    border: 1px solid #e6d3b3;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.2);
}

/* INPUT */
.input-modern {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #d8b58a;
    outline: none;
    box-sizing: border-box;
    background: #fffdf8;
    color: #4b2e1e;
}

.input-modern:focus {
    border-color: #6b3f24;
}

/* BUTTON INSIDE MODAL */
.modal-content button {
    margin-top: 5px;
}

/* EMPTY STATE */
td[colspan] {
    color: #6b5a4a;
}

/* SMOOTH ANIMATION */
button, input, textarea {
    transition: 0.2s ease;
}
</style>

<div class="content">

    <!-- TITLE -->
    <div class="card">
        <h2> Data Petugas</h2>
    </div>

    <!-- SEARCH + BUTTON -->
    <div class="page-header">

        <form method="GET">
            <input type="text" name="search" class="search"
                   placeholder="Cari petugas..."
                   value="{{ request('search') }}">
        </form>

        <button class="btn-add" onclick="openAddModal()">
            + Tambah
        </button>

    </div>

    <!-- TABLE -->
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($petugas as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->no_telepon }}</td>
                    <td>{{ $p->alamat }}</td>

                    <td>
                        <button class="btn-edit"
                            onclick="openEditModal(
                                '{{ $p->id }}',
                                '{{ $p->name }}',
                                '{{ $p->email }}',
                                '{{ $p->no_telepon }}',
                                '{{ $p->alamat }}'
                            )">
                            Edit
                        </button>

                        <form action="{{ route('kepala.petugas.delete', $p->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Belum ada petugas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div class="modal" id="addModal">
    <div class="modal-content">
        <h3>Tambah Petugas</h3>

        <form method="POST" action="{{ route('kepala.petugas.store') }}">
            @csrf

            <input class="input-modern" type="text" name="name" placeholder="Nama">
            <br><br>
            <input class="input-modern" type="email" name="email" placeholder="Email">
            <br><br>
            <input class="input-modern" type="password" name="password" placeholder="Password">
            <br><br>
            <input class="input-modern" type="text" name="no_telepon" placeholder="No Telepon">
            <br><br>
            <textarea class="input-modern" name="alamat" placeholder="Alamat"></textarea>

            <br><br>

            <button type="submit" class="btn-green">Simpan</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Petugas</h3>

        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <input class="input-modern" type="text" id="editName" name="name">
            <br><br>
            <input class="input-modern" type="email" id="editEmail" name="email">
            <br><br>
            <input class="input-modern" type="text" id="editTelp" name="no_telepon">
            <br><br>
            <textarea class="input-modern" id="editAlamat" name="alamat"></textarea>

            <br><br>

            <button type="submit" class="btn-green">Update</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<script>
function openAddModal(){
    document.getElementById('addModal').style.display='flex';
}

function openEditModal(id,name,email,telp,alamat){
    document.getElementById('editModal').style.display='flex';

    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editTelp').value = telp;
    document.getElementById('editAlamat').value = alamat;

    document.getElementById('editForm').action =
        '/dashboard/kepala/petugas/update/' + id;
}

function closeModal(){
    document.getElementById('addModal').style.display='none';
    document.getElementById('editModal').style.display='none';
}
</script>

@endsection