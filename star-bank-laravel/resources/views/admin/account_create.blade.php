<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Account - Star Bank</title>
    <style>
        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: rgba(0,0,0,0.5); font-family: sans-serif; }
        .modal { background: white; padding: 40px; border-radius: 20px; width: 400px; position: relative; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; }
        .btn-container { display: flex; gap: 10px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="modal">
        <a href="/admin/account" style="position: absolute; right: 20px; top: 20px; text-decoration: none; color: #999;">✕</a>
        <h2>Tambah Account</h2>
        <form action="/admin/account/store" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Customer</label>
                <select name="customer_id" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->id }} - {{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Deposito</label>
                <select name="deposito_type_id" required>
                    @foreach($depositoTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Saldo Awal (Rp)</label>
                <input type="number" name="balance" required min="0" placeholder="Contoh: 500000">
            </div>
            <div class="btn-container">
                <a href="/admin/account" style="flex:1; background:#ccc; color:white; padding:12px; border-radius:30px; text-align:center; text-decoration:none;">Batal</a>
                <button type="submit" style="flex:1; background:#66b3ff; color:white; border:none; border-radius:30px; font-weight:bold; cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>