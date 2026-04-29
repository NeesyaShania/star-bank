<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - Star Bank</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; height: 100vh; }
        .modal-box { background: white; padding: 40px; border-radius: 20px; width: 400px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .btn-simpan { background: #66b3ff; color: white; border: none; padding: 12px; border-radius: 30px; cursor: pointer; width: 100%; font-weight: bold; }
    </style>
</head>
<body>
    <div class="modal-box">
        <a href="/admin/customer" style="position: absolute; right: 20px; top: 20px; text-decoration: none; color: #999;">✕</a>
        <h2 style="margin-bottom: 30px;">Edit Customer</h2>
        
        <form action="/admin/customer/update/{{ $customer->id }}" method="POST">
            @csrf
            @method('PUT') <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">Nama</label>
                <input type="text" name="name" value="{{ $customer->name }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">Email</label>
                <input type="email" name="email" value="{{ $customer->email }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px;">PIN (Kosongkan jika tidak diubah)</label>
                <input type="password" name="pin" maxlength="6" placeholder="Masukkan 6 digit baru" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box;">
            </div>

            <div style="display: flex; gap: 15px;">
                <a href="/admin/customer" style="flex: 1; padding: 12px; background: #ccc; color: white; border-radius: 30px; text-decoration: none; text-align: center;">Batal</a>
                <button type="submit" class="btn-simpan" style="flex: 1;">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>