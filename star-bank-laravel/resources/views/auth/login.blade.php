<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Star Bank</title>
    <style>
        body {
            margin: 0; padding: 0; font-family: 'Inter', sans-serif;
            background-color: #a3c9ff; 
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .login-card {
            background: #d9eaff; 
            padding: 40px; border-radius: 20px; width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;
        }
        .logo-container { margin-bottom: 20px; }
        .logo-star { font-size: 67px; color: #4a90e2; }
        .brand-name { font-size: 24px; font-weight: 800; color: #333; margin-top: 5px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        input {
            width: 100%; padding: 15px; border: none; border-radius: 12px;
            box-sizing: border-box; font-size: 1rem; margin-top: 5px;
            outline: none;
        }
        .btn-login {
            width: 100%; padding: 15px; background: #66b3ff; color: white;
            border: none; border-radius: 30px; font-weight: bold; font-size: 1.1rem;
            cursor: pointer; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        #togglePin {
            cursor: pointer;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-container">
            <div class="logo-star">★</div>
            <div class="brand-name">STAR BANK</div>
        </div>
        
        <p style="color: #666; margin-bottom: 25px;">Sign In to Your Account</p>

        @if ($errors->any())
            <div style="color: #e31a1a; font-size: 0.85rem; margin-bottom: 15px; background: #f8d7da; padding: 10px; border-radius: 10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
            </div>
            
            <div class="form-group" style="position: relative;">
                <input type="password" name="pin" id="pinInput" placeholder="Password" required maxlength="6">
                <span id="togglePin" style="position: absolute; right: 15px; top: 18px; color: #999;">👁️</span>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

    <script>
        const togglePin = document.querySelector('#togglePin');
        const pinInput = document.querySelector('#pinInput');

        togglePin.addEventListener('click', function () {
            const type = pinInput.getAttribute('type') === 'password' ? 'text' : 'password';
            pinInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>