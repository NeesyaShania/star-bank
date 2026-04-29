<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit - Star Bank</title>
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
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        select, input {
            width: 100%; padding: 12px; border: 1px solid #ddd;
            border-radius: 10px; box-sizing: border-box; outline: none; font-size: 1rem;
        }
        .btn-submit {
            background: #66b3ff; color: white; border: none;
            padding: 14px; border-radius: 30px; cursor: pointer;
            width: 100%; font-weight: bold; font-size: 1rem; margin-top: 10px;
        }
        .btn-cancel {
            display: block; text-align: center; text-decoration: none;
            color: #999; margin-top: 15px; font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="modal-box">
        <h2 style="margin-bottom: 5px;">Deposit Dana</h2>
        <p style="color: #666; margin-bottom: 25px; font-size: 0.9rem;">Silakan isi formulir setor tunai di bawah ini.</p>
        
        <form action="/customer/deposit" method="POST">
            @csrf
            <div class="form-group">
                <label>Rekening Tujuan</label>
                <select name="account_id" required>
                    <option value="">-- Pilih Rekening --</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->id }} - {{ $acc->depositoType->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Nominal Setoran (Min. 10.000)</label>
                <input type="number" name="amount" min="10000" placeholder="Contoh: 50000" required>
            </div>

            <button type="submit" class="btn-submit">Setor Dana</button>
            <a href="/customer/dashboard" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>
</html>