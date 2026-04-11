@extends('kepala.layouts.app')

@section('title', 'Kelola Petugas')

@section('content')

<style>
    body {
        margin:0;
        font-family:Poppins, sans-serif;
        background:#eae6e3;
    }

    a { text-decoration:none; color:inherit; }

    .content {
        padding:25px;
    }

    .card {
        background:white;
        padding:20px;
        border-radius:12px;
        margin-bottom:20px;
        box-shadow:0 4px 10px rgba(0,0,0,0.08);
    }

    /* BUTTON STYLE (disamain kayak lama) */
    .btn-add {
        background:#6b3f24;
        color:white;
        padding:8px 15px;
        border:none;
        border-radius:6px;
        cursor:pointer;
    }

    .btn-green {
        background:#28a745;
        color:white;
        padding:8px 15px;
        border:none;
        border-radius:6px;
        cursor:pointer;
    }

    .btn-edit {
        background:#0275d8;
        color:white;
        padding:6px 10px;
        border:none;
        border-radius:6px;
        cursor:pointer;
    }

    .btn-delete {
        background:#d9534f;
        color:white;
        padding:6px 10px;
        border:none;
        border-radius:6px;
        cursor:pointer;
    }

    /* TABLE */
    table {
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
    }

    th {
        background:#6b3f24;
        color:white;
        padding:12px;
    }

    td {
        padding:12px;
        text-align:center;
        border-bottom:1px solid #eee;
    }

    tr:hover {
        background:#f5f5f5;
    }

    /* INPUT */
    .search {
        padding:10px 16px;
        border-radius:999px;
        border:1px solid #ddd;
        width:250px;
        outline:none;
    }

    /* MODAL */
    .modal {
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,0.5);
        justify-content:center;
        align-items:center;
        z-index:999;
    }

    .modal-content {
        background:white;
        padding:25px;
        border-radius:12px;
        width:380px;
    }

    .input-modern {
        width:100%;
        padding:10px 12px;
        border-radius:8px;
        border:1px solid #ccc;
        outline:none;
        box-sizing:border-box;
    }

    .input-modern:focus {
        border-color:#6b3f24;
    }

    /* HEADER BAR */
    .page-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    }
</style>

<div class="content">

    <!-- TITLE -->
    <div class="card">
        <h2>👨‍💼 Data Petugas</h2>
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