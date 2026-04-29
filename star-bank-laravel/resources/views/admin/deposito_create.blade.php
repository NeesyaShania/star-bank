<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tipe Deposito - Star Bank</title>
    <style>
        body {
            margin: 0; padding: 0; font-family: 'Inter', sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .modal-box {
            background: white; padding: 40px; border-radius: 20px;
            width: 400px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input {
            width: 100%; padding: 12px; border: 1px solid #ddd;
            border-radius: 10px; box-sizing: border-box; outline: none;
        }
        input:focus { border-color: #66b3ff; }
        .btn-simpan {
            background: #66b3ff; color: white; border: none;
            padding: 14px; border-radius: 30px; cursor: pointer;
            width: 100%; font-weight: bold; font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="modal-box">
        <a href="/admin/deposit" style="position: absolute; right: 20px; top: 20px; text-decoration: none; color: #999;">✕</a>
        <h2 style="margin-bottom: 30px;">Tambah Tipe Deposito</h2>
        
        <form action="/admin/deposit/store" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Deposito</label>
                <input type="text" name="name" placeholder="Contoh: Deposito Silver" required>
            </div>
            
            <div class="form-group">
                <label>Bunga Tahunan (%)</label>
                <input type="number" step="0.01" name="yearly_return" placeholder="Contoh: 5" required>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="/admin/deposit" style="flex: 1; padding: 14px; background: #ccc; color: white; border-radius: 30px; text-decoration: none; text-align: center; font-weight: bold;">Batal</a>
                <button type="submit" class="btn-simpan" style="flex: 1;">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>