<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Bank - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Inter', sans-serif; display: flex; background-color: #f0f7ff; }
        
        .sidebar { 
            width: 240px; height: 100vh; background: #e6f3ff; 
            padding: 40px 20px; box-sizing: border-box; 
            display: flex; flex-direction: column; position: fixed;
            border-right: 1px solid #d1e9ff;
        }

        /* Logo Bintang di Atas Nama Bank */
        .brand-container { text-align: center; margin-bottom: 50px; }
        .logo-star { font-size: 3rem; color: #4a90e2; display: block; line-height: 1; }
        .brand-name { color: #1a73e8; font-weight: 800; font-size: 1.4rem; letter-spacing: 1px; }

        .menu-label { font-size: 0.75rem; color: #888; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; }
        .menu-item { 
            display: flex; align-items: center; padding: 12px 15px; 
            text-decoration: none; color: #333; font-weight: 600; 
            border-radius: 12px; margin-bottom: 10px;
        }
        .menu-item.active { background: white; color: #1a73e8; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

        .btn-logout {
            background: #ff5c5c; color: white; border: none;
            padding: 14px; border-radius: 12px; font-weight: bold;
            cursor: pointer; width: 100%; font-size: 1rem; margin-top: auto;
        }

        .main-content { margin-left: 240px; flex: 1; padding: 40px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand-container">
            <span class="logo-star">★</span>
            <span class="brand-name">STAR BANK</span>
        </div>

        <div class="menu-label">Utama</div>
        <a href="/customer/dashboard" class="menu-item active">
             🏠 <span style="margin-left: 10px;">Dashboard</span>
        </a>

        <form action="/logout" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit" class="btn-logout">🚪 Log Out</button>
        </form>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>