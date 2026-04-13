@extends('kepala.layouts.app')
@section('content')

<style>
/* BACKGROUND VINTAGE */
body {
    font-family: Poppins, sans-serif;
    background: #e9e2d6;
}

/* WELCOME BOX */
.welcome-box {
    background: linear-gradient(135deg,#6b3f24,#8b5a2b);
    color: #fff;
    padding: 25px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.25);
    border: 1px solid #d8b58a;
}

.welcome-box h2 {
    margin: 0;
}

.welcome-box p {
    margin-top: 5px;
    opacity: 0.9;
}

/* STAT CARDS */
.stat-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.card-stat {
    flex: 1;
    min-width: 200px;
    padding: 20px;
    border-radius: 16px;
    color: white;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.2);
    transition: 0.3s ease;
    cursor: pointer;
    border: 1px solid rgba(216,181,138,0.5);
}

.card-stat:hover {
    transform: translateY(-8px) scale(1.03);
}

/* GRID */
.grid {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 25px;
}

/* BOX VINTAGE */
.box {
    background: #fffaf3;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(90, 60, 30, 0.12);
    border: 1px solid #e6d3b3;
}

/* CHART BOX */
.chart-box {
    flex: 2;
    min-width: 400px;
}

/* ACTIVITY BOX */
.activity-box {
    flex: 1;
    min-width: 280px;
}

/* ACTIVITY ITEM */
.activity-item {
    padding: 10px;
    border-bottom: 1px solid #ead9c3;
    font-size: 14px;
    color: #4b2e1e;
}

.activity-item b {
    color: #6b3f24;
}



/* CANVAS */
canvas {
    margin-top: 20px;
}

/* SMOOTH TRANSITION */
* {
    transition: 0.2s ease;
}
</style>

<!-- WELCOME -->
<div class="welcome-box">
    <h2>
        Halo, {{ session('user')->username ?? 'Admin' }} 👋
    </h2>
    <p style="margin-top:5px; opacity:0.9;">
        Selamat datang di dashboard kepala perpustakaan
    </p>
</div>

<!-- CARD -->
<div class="stat-container">

    <div class="card-stat" style="background:linear-gradient(135deg,#43a047,#66bb6a);">
        <h2>📚 {{ $totalBuku }}</h2>
        <p>Total Buku</p>
    </div>

    <div class="card-stat" style="background:linear-gradient(135deg,#1e88e5,#42a5f5);">
        <h2>👥 {{ $totalAnggota }}</h2>
        <p>Total Anggota</p>
    </div>

    <div class="card-stat" style="background:linear-gradient(135deg,#f4b400,#ffd54f);">
        <h2>📖 {{ $totalPeminjaman }}</h2>
        <p>Total Peminjaman</p>
    </div>

    <div class="card-stat" style="background:linear-gradient(135deg,#e53935,#ef5350);">
        <h2>💰 Rp {{ number_format($totalDenda,0,',','.') }}</h2>
        <p>Total Denda</p>
    </div>

</div>

<!-- GRID -->
<div class="grid">

    <!-- STATISTIK -->
    <div class="box chart-box">

        <!-- STATISTIK -->
<div class="box chart-box">

    <h3>📊 Statistik Peminjaman (7 Hari Terakhir)</h3>

    <canvas id="chart" height="120" style="margin-top:20px;"></canvas>

</div>
        <canvas id="chart" height="120" style="margin-top:20px;"></canvas>

    </div>

    <!-- AKTIVITAS -->
    <div class="box activity-box">

        <h3>⚡ Aktivitas Terbaru</h3>

        <div style="margin-top:15px;">

            @foreach($aktivitas as $a)
            <div class="activity-item">

                <b>{{ $a->user->name ?? '-' }}</b><br>
meminjam <b>{{ $a->buku->judul ?? '-' }}</b>

                <br>

                <small style="color:gray;">
                    {{ $a->created_at ? \Carbon\Carbon::parse($a->created_at)->diffForHumans() : '-' }}
                </small>

            </div>
            @endforeach

        </div>

    </div>

</div>

<canvas id="chart"></canvas>

<!-- INI WAJIB DI ATAS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
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
<script>
let chart;



function renderChart(labels, pinjam, kembali){

    if(chart) chart.destroy();

    chart = new Chart(document.getElementById('chart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Peminjaman',
                    data: pinjam,
                    borderWidth: 3,
                    tension: 0.4
                },
                {
                    label: 'Pengembalian',
                    data: kembali,
                    borderWidth: 3,
                    tension: 0.4
                }
            ]
        }
    });
}

loadMingguan();
</script>

@endsection