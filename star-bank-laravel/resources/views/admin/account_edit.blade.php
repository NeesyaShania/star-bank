<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Account - Star Bank</title>
    <style>
        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: rgba(0,0,0,0.5); font-family: sans-serif; }
        .modal { background: white; padding: 40px; border-radius: 20px; width: 400px; position: relative; }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="modal">
        <a href="/admin/account" style="position: absolute; right: 20px; top: 20px; text-decoration: none; color: #999;">✕</a>
        <h2>Edit Account</h2>
        <form action="/admin/account/update/{{ $account->id }}" method="POST">
            @csrf
            @method('PUT')
            
            <label>ID Account</label>
            <input type="text" value="{{ $account->id }}" disabled style="background: #f9f9f9;">

            <label>Jenis Deposito</label>
            <select name="deposito_type_id" required>
                @foreach($depositoTypes as $type)
                    <option value="{{ $type->id }}" {{ $account->deposito_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>

            <label>Saldo (Rp)</label>
            <input type="number" name="balance" value="{{ $account->balance }}" required min="0">

            <div style="display: flex; gap: 10px;">
                <a href="/admin/account" style="flex:1; background:#ccc; color:white; padding:12px; border-radius:30px; text-align:center; text-decoration:none;">Batal</a>
                <button type="submit" style="flex:1; background:#66b3ff; color:white; border:none; border-radius:30px; font-weight:bold;">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>