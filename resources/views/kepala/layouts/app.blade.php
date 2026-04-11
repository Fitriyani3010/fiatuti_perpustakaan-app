<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Dashboard Kepala')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #eae6e3;
}

/* HEADER */
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

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;

    background: #6b3f24;
    padding: 90px 15px 20px;

    border-radius: 0 20px 20px 0;
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
    gap: 10px;
}

.nav-item {
    background: #8b5535;
    padding: 12px;
    border-radius: 10px;
    color: white;
    text-decoration: none;
    transition: 0.2s;
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

/* MAIN */
.main {
    margin-left: 260px;
    padding: 100px 25px 25px;
}

/* USER */
.user {
    background: #ffffff20;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 13px;
}

        /* LOGOUT */
        .sb-bottom {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .nav-item.logout {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: none;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .nav-item.logout:hover {
            background: #ef4444;
            color: white;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 20px;
            }
        }

        /* card */
        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /*table */
        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .table-modern thead {
            background: #f8fafc;
            color: #64748b;
            font-size: 13px;
        }

        .table-modern th,
        .table-modern td {
            padding: 14px;
            text-align: left;
        }

        .table-modern tbody tr {
            border-top: 1px solid #e5e7eb;
            transition: 0.2s;
        }

        .table-modern tbody tr:hover {
            background: #f1f5f9;
        }

        /*badge */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .badge.green {
            background: #10b981;
        }

        .badge.red {
            background: #ef4444;
        }

        .badge.orange {
            background: #f59e0b;
        }

        /* pagination */
        .pagination {
            display: flex;
            gap: 6px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination li {
            list-style: none;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            color: #334155;
            font-size: 13px;
            transition: 0.2s;
        }

        .pagination a:hover {
            background: #2563eb;
            color: white;
        }

        .pagination .active span {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .pagination .disabled span {
            opacity: 0.5;
        }
    </style>
</head>

<body>
   <body>

<!-- HEADER -->
<div class="header">
    <h3>📖 TreebanBooks</h3>

    <div style="display:flex; align-items:center; gap:10px;">
        

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                background:#ef4444;
                border:none;
                padding:6px 14px;
                border-radius:8px;
                color:white;
                cursor:pointer;
            ">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- SIDEBAR -->
<aside class="sidebar">

    <a href="{{ route('kepala.profile') }}" style="text-decoration:none; color:white;">
    <div class="sb-profile" style="cursor:pointer;">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}">
        <h4>{{ auth()->user()->name }}</h4>
        <span>Kepala</span>
    </div>
</a>
    <nav class="sb-nav">
        <a href="{{ route('kepala.home') }}" class="nav-item {{ request()->routeIs('kepala.home') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

       <a href="{{ route('kepala.data_buku') }}" class="nav-item {{ request()->routeIs('kepala.data_buku') ? 'active' : '' }}">
            📚 Data Buku
        </a>

        <a href="{{ route('kepala.petugas') }}" class="nav-item {{ request()->routeIs('kepala.petugas') ? 'active' : '' }}">
            👨‍💼 Petugas
        </a>

        <a href="{{ route('kepala.laporan.anggota') }}" class="nav-item {{ request()->routeIs('kepala.laporan.anggota') ? 'active' : '' }}">
            👥 Anggota
        </a>

        <a href="{{ route('kepala.laporan.peminjaman') }}" class="nav-item {{ request()->routeIs('kepala.laporan.peminjaman') ? 'active' : '' }}">
            📦 Peminjaman
        </a>

        <a href="{{ route('kepala.laporan.denda') }}" class="nav-item {{ request()->routeIs('kepala.laporan.denda') ? 'active' : '' }}">
            💰 Denda
        </a>
    </nav>

</aside>

<!-- MAIN -->
<main class="main">
    @yield('content')
</main>

</body>
</body>

</html>
