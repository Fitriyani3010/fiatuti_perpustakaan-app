<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
       /* RESET */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* BODY */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #eae6e3;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;

    background: #6b3f24;
    padding: 90px 15px 20px; /* 🔥 dorong isi ke bawah header */
    
    border-radius: 0 20px 20px 0;

    z-index: 10; /* 🔥 lebih kecil dari header */
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
.nav-item.logout {
    background: #ef4444;
}

/* HEADER */
.header {
    position: fixed;
    top: 0;
    left: 0;   /* 🔥 full dari kiri */
    right: 0;  /* 🔥 full ke kanan */
    height: 70px;

    background: #6b3f24;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    color: white;

    border-radius: 0 0 15px 15px; /* 🔥 cuma bawah yang rounded */
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    z-index: 9999;
}
/* MAIN */
.main {
     margin-left: 260px;
    padding: 100px 25px 25px; /* kasih jarak dari header */

}

/* AVATAR */
.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    background: #2563EB;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color:white;
}
.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
    </style>

    @stack('styles')
</head>

<body>
    <!-- HEADER -->
     
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

 <aside class="sidebar">

   <a href="{{ route('user.profile') }}" style="text-decoration:none; color:white;">
    <div class="sb-profile" style="cursor:pointer;">
       <img src="{{ asset('storage/foto/' . auth()->user()->foto) }}">
        <h4>{{ auth()->user()->name }}</h4>
        <span>Anggota</span>
    </div>
</a>

    <!-- MENU -->
    <nav class="sb-nav">
        <a href="{{ route('user.home') }}" class="nav-item {{ request()->routeIs('user.home') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

        <a href="{{ route('user.library') }}" class="nav-item {{ request()->routeIs('user.library') ? 'active' : '' }}">
            📚 Daftar Buku
        </a>

        <a href="{{ route('user.riwayat') }}" class="nav-item {{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
            📦 Peminjaman
        </a>

        <a href="{{ route('user.denda') }}" class="nav-item {{ request()->routeIs('user.denda') ? 'active' : '' }}">
            💰 Denda
        </a>

        
    </nav>

   

</aside>
    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="user-pill">

               

               
            </div>
        </div>

        {{-- CONTENT --}}
        @yield('content')

    </main>

    @stack('scripts')
    
</body>

</html>
