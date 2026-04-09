@extends('kepala.layouts.app')
@section('content')
    <style>
        .page-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 14px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .card p {
            font-size: 13px;
            color: #6b7280;
        }

        .card h2 {
            margin-top: 5px;
            font-size: 22px;
        }

        .table-box {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            margin-bottom: 20px;
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
            color: #6b7280;
            border-bottom: 1px solid #eee;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .green {
            background: #10b981;
        }

        .yellow {
            background: #f59e0b;
        }

        .red {
            background: #ef4444;
        }
    </style>
    {{-- cards --}}
    <div class="cards">
        <div class="card">
            <p>Total Buku</p>
            <h2>{{ number_format($totalBuku) }}</h2>
        </div>
        <div class="card">
            <p>Total Anggota</p>
            <h2>{{ number_format($totalAnggota) }}</h2>
        </div>
        <div class="card">
            <p>Total Peminjaman</p>
            <h2>{{ number_format($totalPeminjaman) }}</h2>
        </div>
        <div class="card">
            <p>Total Denda</p>
            <h2>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
        </div>
    </div>
    {{-- petugas --}}
    <div class="table-box">
        <h4 style="margin-bottom:10px;">Data Petugas</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petugas as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>
                            <span class="badge green">Aktif</span>
                        </td>
                        <td>-</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- buku --}}
    <div class="table-box">
        <h4 style="margin-bottom:10px;">Buku Populer</h4>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bukuPopuler as $buku)
                    <tr>
                        <td>{{ $buku->judul }}</td>
                        <td>
                            @if ($buku->stok > 5)
                                <span class="badge green">Tersedia</span>
                            @elseif($buku->stok > 0)
                                <span class="badge yellow">Terbatas</span>
                            @else
                                <span class="badge red">Habis</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
