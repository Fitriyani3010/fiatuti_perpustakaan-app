@extends('petugas.layouts.app')

@section('content')
    <style>
        .page-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .denda-card {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .table-box {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .red {
            background: #ef4444;
        }

        .green {
            background: #10b981;
        }
    </style>
    <h4 class="page-title">Kelola Denda</h4>
    <div class="denda-card">
        <h3>Total Denda Aktif</h3>
        <h1>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h1>
    </div>
    <div class="table-box">
        <table width="100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Buku</th>
                    <th>Terlambat</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>
                            {{ $item->terlambat }} Hari
                        </td>
                        <td>
                            Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($item->total_denda > 0)
                                <span class="badge red">Belum Bayar</span>
                            @else
                                <span class="badge green">Lunas</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Tidak ada data denda
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
