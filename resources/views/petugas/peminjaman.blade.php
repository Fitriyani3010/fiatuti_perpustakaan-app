@extends('petugas.layouts.app')

@section('content')
    <style>
        .page-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .table-box {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .header input {
            padding: 8px 14px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            font-size: 14px;
        }

        th {
            text-align: left;
            border-bottom: 1px solid #eee;
            color: #6B7280;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #fff;
        }

        .waiting {
            background: orange;
        }

        .borrowed {
            background: #3b82f6;
        }

        .late {
            background: #ef4444;
        }

        .done {
            background: #10b981;
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 8px;
            border: none;
            font-size: 12px;
            cursor: pointer;
        }

        .btn.green {
            background: #10b981;
            color: white;
        }

        .btn.blue {
            background: #3b82f6;
            color: white;
        }

        .btn.red {
            background: #ef4444;
            color: white;
        }
    </style>
    <h4 class="page-title">Kelola Peminjaman</h4>
    <div class="table-box">
        <div class="header">
            <div></div>
            <input type="text" id="search" placeholder="Search...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($data as $item)
                    @php
                        $hari = $item->tanggal_pinjam
                            ? \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays(now())
                            : 0;
                        $terlambat = $item->status == 'dipinjam' && $hari > 7;
                    @endphp
                    <tr>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku->judul }}</td>
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
                                        <button class="btn green" onclick="return confirm('Setujui peminjaman ini?')">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                @if ($item->status == 'dipinjam')
                                    <form action="{{ route('petugas.peminjaman.return', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="btn blue" onclick="return confirm('Yakin buku sudah dikembalikan?')">
                                            Return
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection
