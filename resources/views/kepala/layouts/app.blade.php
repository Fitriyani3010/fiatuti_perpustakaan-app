<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Dashboard Kepala')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
        }

        .dashboard {
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            display: block;
            padding: 10px;
            color: #cbd5f5;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .active a {
            background: #2563eb;
            color: white;
        }

        /* MAIN */
        .main {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }

        .header h1 {
            font-size: 22px;
        }

        /* USER NAME */
        .user {
            background: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
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
            color: white; /* 🔥 FIX */
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
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>👑 Kepala</h2>
            <ul>
                <li class="{{ request()->routeIs('kepala.home') ? 'active' : '' }}">
                    <a href="{{ route('kepala.home') }}">Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('kepala.petugas') ? 'active' : '' }}">
                    <a href="{{ route('kepala.petugas') }}">Kelola Petugas</a>
                </li>
            </ul>
            <div class="sb-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item logout">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="main">
            <div class="header">
                <h1>@yield('title', 'Dashboard')</h1>
                <div class="user">
                    {{ auth()->user()->name }}
                </div>
            </div>
            @yield('content')
        </div>
    </div>
    @yield('script')
</body>
</html>