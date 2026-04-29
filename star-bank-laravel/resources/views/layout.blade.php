<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Bank - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/AdminDashboard.css') }}">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar" style="display: flex; flex-direction: column;">
            <div class="sidebar-top">
                <div class="sidebar-header">
                    <div class="logo-star-small">★</div>
                    <h1 class="sidebar-title">STAR BANK</h1>
                </div>

                <p class="menu-label" style="margin-top: 20px;">UTAMA</p>
                <nav class="admin-nav">
                    <div class="nav-group {{ Request::is('admin/customer*') ? 'active' : '' }}">
                        <span class="icon">👤</span><a href="/admin/customer" class="nav-link">Data Customer</a>
                    </div>
                    <div class="nav-group {{ Request::is('admin/account*') ? 'active' : '' }}">
                        <span class="icon">💳</span><a href="/admin/account" class="nav-link">Data Account</a>
                    </div>
                    <div class="nav-group {{ Request::is('admin/deposit*') ? 'active' : '' }}">
                        <span class="icon">📊</span><a href="/admin/deposit" class="nav-link">Tipe Deposit</a>
                    </div>
                </nav>
            </div>

            <div class="sidebar-bottom" style="margin-top: auto; padding-bottom: 20px;">
                <div class="nav-group">
                    <span class="icon">↪️</span>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>

                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
            </div>
        </aside>

        <main className="admin-main">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>