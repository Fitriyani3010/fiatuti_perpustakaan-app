@extends('petugas.layouts.app')

@section('content')
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

       table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
th {
    background: #6b3f24;
    color: white;
    padding: 14px 10px;
    font-weight: 600;
    font-size: 14px;
    text-align: center;
}

/* ISI */
td {
    padding: 12px 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
    text-align: center;

    /* 🔥 INI KUNCI BIAR RAPI */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}



/* LEBAR KOLOM FIX */
th:nth-child(1), td:nth-child(1) { width: 15%; } /* nama */
th:nth-child(2), td:nth-child(2) { width: 18%; } /* email */
th:nth-child(3), td:nth-child(3) { width: 12%; } /* nisn */
th:nth-child(4), td:nth-child(4) { width: 10%; } /* kelas */
th:nth-child(5), td:nth-child(5) { width: 13%; } /* hp */
th:nth-child(6), td:nth-child(6) { width: 22%; } /* alamat */
th:nth-child(7), td:nth-child(7) { width: 10%; } /* aksi */

/* HOVER */
tr {
    transition: 0.2s;
}

tr:hover {
    background: #f9f6f3;
}

/* AKSI BUTTON BIAR RAPI */
.action-group {
    display: flex;
    justify-content: center;
    gap: 6px;
}

/* TABLE BOX */
.table-box {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}
      
        .edit {
            background: #7aabfb;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        .hapus {
            background: #ef4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn {
            background: #10b981;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 350px;
        }

        .modal input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        
    </style>

    <div style="margin-bottom:20px;">
    <h2 style="margin-bottom:10px;">👥 Kelola Anggota</h2>

    <form method="GET" style="display:flex; gap:10px; max-width:400px;">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama / email..."
               style="
                   flex:1;
                   padding:10px 14px;
                   border-radius:999px;
                   border:1px solid #ddd;
                   outline:none;
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
                                    Delete
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
