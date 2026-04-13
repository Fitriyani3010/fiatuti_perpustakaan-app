@extends('petugas.layouts.app')

@section('content')
    <style>
       /* HEADER TITLE */
h2 {
    color: #4b2e1e;
   
}

/* SEARCH BOX (lebih kotak, ga bulet banget) */
form input[type="text"] {
    flex: 1;
    padding: 10px 14px;
    border-radius: 10px; /* 🔥 sebelumnya 999px */
    border: 1px solid #d6c2b5;
    background: #fffaf5;
    color: #4b2e1e;
    outline: none;
    transition: 0.2s;
}

form input[type="text"]:focus {
    border-color: #6b3f24;
    box-shadow: 0 0 0 2px rgba(107,63,36,0.15);
}

/* BUTTON SEARCH */
form button {
    padding: 10px 16px;
    border-radius: 10px; /* 🔥 lebih clean */
    border: none;
    background: #6b3f24;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(75,46,30,0.2);
}

/* TABLE BOX */
.table-box {
    background: #fdf8f3;
    padding: 22px;
    border-radius: 20px;
    border: 1px solid #e6d5c3;
    box-shadow: 0 10px 30px rgba(75, 46, 30, 0.15);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
   
}

/* HEADER */
th {
    background: linear-gradient(135deg, #6b3f24, #8b5e3c);
    color: #fff8f0;
    padding: 14px 10px;
    font-size: 13px;
    letter-spacing: 0.5px;
    text-align: center;
    border-bottom: 2px solid #d6c2b5;
}

/* DATA */
td {
    padding: 12px 10px;
    font-size: 14px;
    color: #4b2e1e;
    border-bottom: 1px dashed #e0cfc2;
    text-align: center;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* STRIPED */
tbody tr:nth-child(even) {
    background: #f7efe8;
}

/* HOVER */
tr:hover {
    background: #f1e4d8;
    transition: 0.3s;
}

/* ACTION BUTTON */
.edit {
    background: #4a6fa5; /* biru vintage */
    border-radius: 8px;
}

.hapus {
    background: #a94438; /* merah bata */
    border-radius: 8px;
}

/* BUTTON UMUM */
.btn {
    background: #6b8e23; /* olive */
    border-radius: 10px;
}

/* TABLE BOX */
.table-box {
    background: #fdf8f3;
    padding: 22px;
    border-radius: 20px;
    border: 1px solid #e6d5c3;
    box-shadow: 0 10px 30px rgba(75, 46, 30, 0.15);
}

/* MODAL OVERLAY */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(75, 46, 30, 0.6);
    backdrop-filter: blur(3px);
    justify-content: center;
    align-items: center;
}

/* MODAL BOX */
.modal form {
    background: #fdf8f3;
    padding: 25px;
    border-radius: 20px;
    width: 350px;
    border: 1px solid #e6d5c3;
    box-shadow: 0 15px 35px rgba(75, 46, 30, 0.3);
}

/* INPUT MODAL */
.modal input {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #d6c2b5;
    background: #fffaf5;
    color: #4b2e1e;
}

/* BUTTON MODAL */
.modal .btn {
    margin-top: 10px;
}
.action-group {
    display: flex;
    justify-content: center;
    gap: 10px; /* ⬅️ tambahin jarak */
}
.edit {
    background: #4a6fa5;
    color: white;
    border: none;
    padding: 6px 12px; /* ⬅️ lebih lebar */
    border-radius: 8px;
    cursor: pointer;
}

.hapus {
    background: #a94438;
    color: white;
    border: none;
    padding: 6px 12px; /* ⬅️ samain */
    border-radius: 8px;
    cursor: pointer;
}
        
    </style>

    <div style="margin-bottom:20px;">
    <h2 style="margin-bottom:10px;"> Kelola Anggota</h2>

    <form method="GET" style="display:flex; gap:10px; max-width:400px;">
        <input type="text"
   name="search"
   value="{{ request('search') }}"
   placeholder="Cari nama / email..."
   style="
       flex:1;
       padding:10px 14px;
       border-radius:6px; /* ⬅️ FIX */
       border:1px solid #d6c2b5;
       outline:none;
       background:#fdf8f3;
   ">

        <button type="submit"
                style="
                    padding:10px 16px;
                    border:none;
                    border-radius:999px;
                    background:#6b3f24;
                    color:white;
                    cursor:pointer;
                ">
            Cari
        </button>
    </form>
</div>

   <div class="table-box">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($anggotas as $a)
                <tr>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->nisn ?? '-' }}</td>
                    <td>{{ $a->kelas ?? '-' }}</td>
                    <td>{{ $a->no_telepon ?? '-' }}</td>
                    <td>{{ $a->alamat ?? '-' }}</td>
                    <td>
                        <div class="action-group">
                            <button type="button" class="edit" onclick='editData(@json($a))'>
                                Edit
                            </button>

                            <form action="{{ route('petugas.anggota.delete', $a->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hapus">
                                    Hapus
                                </button>
                            </form>
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

    <div style="margin-top:10px; font-size:13px;">
        Menampilkan {{ $anggotas->firstItem() ?? 0 }} - {{ $anggotas->lastItem() ?? 0 }}
        dari {{ $anggotas->total() }} data
    </div>
</div>

       
    <div style="margin-top:20px;">
        {{ $anggotas->links() }}
    </div>

    {{-- MODAL --}}
    <div id="modal" class="modal">
        <form method="POST" id="form">
            @csrf
            <input type="hidden" name="_method" id="method">
            <h3 id="title">Tambah Anggota</h3>
            <input type="text" name="name" id="name" placeholder="Nama" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="no_telepon" id="no_telepon" placeholder="No HP">
            <input type="text" name="alamat" id="alamat" placeholder="Alamat">
            <input type="password" name="password" id="password" placeholder="Password (kosongkan jika tidak diubah)">
            <br>
            <button type="submit" class="btn">Simpan</button>
            <button type="button" onclick="closeModal()">Batal</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('form').action = "{{ route('petugas.anggota.store') }}";
            document.getElementById('method').value = '';
            document.getElementById('title').innerText = 'Tambah Anggota';
            document.getElementById('password').style.display = 'block';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('no_telepon').value = '';
            document.getElementById('alamat').value = '';
            document.getElementById('password').value = '';
        }

        function editData(data) {
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('form').action = "/dashboard/petugas/anggota/update/" + data.id;
            document.getElementById('method').value = 'PUT';
            document.getElementById('title').innerText = 'Edit Anggota';
            document.getElementById('password').style.display = 'block';
            document.getElementById('password').value = '';
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('no_telepon').value = data.no_telepon ?? '';
            document.getElementById('alamat').value = data.alamat ?? '';
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
