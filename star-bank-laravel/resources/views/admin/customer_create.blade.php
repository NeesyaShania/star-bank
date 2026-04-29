<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Customer - Star Bank</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: rgba(0, 0, 0, 0.5); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .modal-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 400px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-simpan {
            background: #66b3ff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="modal-box">
        <a href="/admin/customer" style="position: absolute; right: 20px; top: 20px; text-decoration: none; color: #999;">✕</a>
        <h2 style="margin-bottom: 30px;">Tambah Customer</h2>
        
        <form action="/admin/customer/store" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">Nama</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px;">PIN</label>
                <div style="position: relative;">
                    <input type="password" id="pin" name="pin" maxlength="6" required 
                        placeholder="Masukkan 6 digit angka"
                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
                    
                    <span id="togglePin" style="position: absolute; right: 15px; top: 12px; cursor: pointer; color: #666;">
                        👁️
                    </span>
                </div>
                <small style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px; display: block;">
                    * PIN harus berjumlah tepat 6 digit angka.
                </small>
            </div>

            <script>
                const togglePin = document.querySelector('#togglePin');
                const pinInput = document.querySelector('#pin');

                togglePin.addEventListener('click', function() {
                    const type = pinInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    pinInput.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '🕶️';
                });
            </script>
            <div style="display: flex; gap: 15px;">
                <a href="/admin/customer" style="flex: 1; padding: 12px; background: #ccc; color: white; border-radius: 30px; text-decoration: none; text-align: center;">Batal</a>
                <button type="submit" class="btn-simpan" style="flex: 1;">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>