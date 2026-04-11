@extends('kepala.layouts.app')
@section('content')

<style>
/* WELCOME */
.welcome-box {
    background: linear-gradient(135deg,#6b3f24,#a47148);
    color: white;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* CARD STAT */
.stat-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.card-stat {
    flex: 1;
    min-width: 200px;
    padding: 20px;
    border-radius: 14px;
    color: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: 0.3s;
    cursor: pointer;
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

.box {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* chart & aktivitas */
.chart-box {
    flex: 2;
    min-width: 400px;
}

.activity-box {
    flex: 1;
    min-width: 280px;
}

.activity-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
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