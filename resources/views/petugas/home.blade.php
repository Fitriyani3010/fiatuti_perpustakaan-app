@extends('petugas.layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
     .dashboard {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* CARDS */
.cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 180px;
    color: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* WARNA SESUAI STYLE LAMA */
.card.blue { background: #2196F3; }
.card.green { background: #4CAF50; }
.card.red { background: #e74c3c; }
.card.orange { background: #f4c542; color: #333; }

/* GRID */
.grid-2 {
    display: flex;
    gap: 20px;
}

/* SECTION */
.section {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* CHART */
.chart-box {
    flex: 2;
}

/* AKTIVITAS */
.activity-box {
    flex: 1;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 10px;
}

th {
    background: #6b3f24;
    color: white;
    padding: 12px;
    text-align: left;
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

tr {
    background: #fafafa;
    transition: 0.2s;
}

tr:hover {
    background: #f1f1f1;
}

/* BADGE */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    color: white;
}

.waiting { background: orange; }
.borrowed { background: #3b82f6; }
.done { background: #10b981; }

/* ACTIVITY ITEM */
.activity-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
}
    </style>
    <div class="dashboard">
        {{-- HEADER --}}
        <div>
            <h2>Dashboard Petugas</h2>
            <small>Selamat datang, {{ auth()->user()->name }}</small>
        </div>
        {{-- CARDS --}}
        <div class="cards">
            <div class="card blue">
                <p>Total Anggota</p>
                <h2>{{ $totalAnggota }}</h2>
            </div>
            <div class="card green">
                <p>Total Buku</p>
                <h2>{{ $totalBuku }}</h2>
            </div>
            <div class="card blue">
                <p>Peminjaman Aktif</p>
                <h2>{{ $peminjamanAktif }}</h2>
            </div>
            <div class="card red">
                <p>Total Denda</p>
                <h2>Rp {{ number_format($totalDenda) }}</h2>
            </div>
            <div class="card orange">
                <p>Menunggu</p>
                <h2>{{ $menunggu }}</h2>
            </div>

    {{-- CHART --}}
    <div class="section chart-box">
        <h3>Grafik Peminjaman (7 Hari)</h3>
        <canvas id="chart"></canvas>
    </div>

    {{-- AKTIVITAS --}}
    <div class="section activity-box">
        <h3>Aktivitas</h3>

        @foreach ($recentPeminjaman as $item)
            <div class="activity-item">
                <b>{{ $item->user->name }}</b><br>
                meminjam <b>{{ $item->buku->judul }}</b>

                <br>
                <small style="color:gray;">
                    {{ $item->created_at->diffForHumans() }}
                </small>
            </div>
        @endforeach

    </div>

</div>
    <script>
        // chart
        const ctx = document.getElementById('chart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Peminjaman',
                    data: @json($chartData),
                    borderWidth: 2,
                    tension: 0.3
                }]
            }
        });
    </script>
@endsection
