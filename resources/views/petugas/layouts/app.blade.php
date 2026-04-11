<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Petugas')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* BODY */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #eae6e3;
}

/* HEADER (FULL BAR) */
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;

    background: #6b3f24;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    color: white;

    border-radius: 0 0 15px 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    z-index: 9999;
}

/* SIDEBAR (KETUTUP HEADER) */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;

    background: #6b3f24;
    padding: 90px 15px 20px; /* 🔥 penting biar turun dari header */

    border-radius: 0 20px 20px 0;
    z-index: 10;
}

/* PROFILE */
.sb-profile {
    text-align: center;
    margin-bottom: 25px;
}

.sb-profile img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
}

.sb-profile h4 {
    margin: 10px 0 5px;
}

.sb-profile span {
    background: #d97706;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
}

/* MENU */
.sb-nav {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.nav-item {
    background: #8b5535;
    padding: 12px 14px;
    border-radius: 10px;
    color: white;
    text-decoration: none;
    transition: 0.2s;
    font-size: 14px;
}

.nav-item:hover {
    background: #a8643d;
}

.nav-item.active {
    background: #c97a4a;
}

/* LOGOUT */
.logout-btn {
    background: #ef4444;
    border: none;
    padding: 10px;
    border-radius: 10px;
    color: white;
    cursor: pointer;
    width: 100%;
}

/* MAIN */
.main {
    margin-left: 260px;
    padding: 100px 25px 25px;
}

/* CARD (biar nyatu style lama) */
.card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}
    </style>

    @stack('styles')
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h3>📖 TreebanBooks</h3>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="
            background:#ef4444;
            border:none;
            padding:8px 16px;
            border-radius:8px;
            color:white;
            cursor:pointer;
        ">
            Logout
        </button>
    </form>
</div>

<!-- SIDEBAR -->
<aside class="sidebar">
<a href="{{ route('petugas.profile') }}" style="text-decoration:none; color:white;">
    <div class="sb-profile" style="cursor:pointer;">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}">
        <h4>{{ auth()->user()->name }}</h4>
        <span>Petugas</span>
    </div>
</a>

    <nav class="sb-nav">
        <a href="{{ route('petugas.home') }}" class="nav-item {{ request()->routeIs('petugas.home') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

        <a href="{{ route('petugas.anggota') }}" class="nav-item {{ request()->routeIs('petugas.anggota') ? 'active' : '' }}">
            👥 Anggota
        </a>

        <a href="{{ route('petugas.kategori') }}" class="nav-item {{ request()->routeIs('petugas.kategori') ? 'active' : '' }}">
            📂 Kategori
        </a>

        <a href="{{ route('petugas.buku') }}" class="nav-item {{ request()->routeIs('petugas.buku') ? 'active' : '' }}">
            📚 Buku
        </a>

        <a href="{{ route('petugas.peminjaman') }}" class="nav-item {{ request()->routeIs('petugas.peminjaman') ? 'active' : '' }}">
            📦 Peminjaman
        </a>

        <a href="{{ route('petugas.denda') }}" class="nav-item {{ request()->routeIs('petugas.denda') ? 'active' : '' }}">
            💰 Denda
        </a>
    </nav>

</aside>

<!-- MAIN -->
<main class="main">
    @yield('content')
</main>

@yield('script')

</body>
</html>