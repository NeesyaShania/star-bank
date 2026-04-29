<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw - Star Bank</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; height: 100vh; }
        .modal-box { background: white; padding: 40px; border-radius: 25px; width: 420px; position: relative; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        select, input { width: 100%; padding: 14px; border: 1px solid #ddd; border-radius: 12px; box-sizing: border-box; outline: none; font-size: 1rem; }
        .info-box { background: #e7f3ff; border-radius: 12px; padding: 15px; font-size: 0.85rem; color: #0056b3; margin-bottom: 20px; line-height: 1.5; }
        .calculation-area { background: #f9f9f9; padding: 15px; border-radius: 12px; margin-top: 15px; font-size: 0.85rem; color: #555; }
        .calc-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .total-bold { font-weight: 800; color: #222; border-top: 1px solid #ddd; padding-top: 8px; margin-top: 8px; }
        .btn-withdraw { background: #ff4d4d; color: white; border: none; padding: 16px; border-radius: 30px; cursor: pointer; width: 100%; font-weight: bold; font-size: 1.1rem; margin-top: 20px; box-shadow: 0 4px 12px rgba(255, 77, 77, 0.3); }
        .btn-cancel { display: block; text-align: center; text-decoration: none; color: #999; margin-top: 15px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="modal-box">
        <h2 style="margin: 0 0 5px 0;">Tarik Dana (Withdraw)</h2>
        <p style="color: #666; margin-bottom: 20px; font-size: 0.9rem;">Saldo akan berkurang setelah penarikan.</p>

        <div class="info-box">
            💡 <strong>Info:</strong> Tarik dana sekarang untuk mendapatkan bonus bunga bulanan otomatis!
        </div>
        
        <form action="/customer/withdraw" method="POST">
            @csrf
            <div class="form-group">
                <label>Sumber Rekening</label>
                <select name="account_id" id="accountSelect" required>
                    <option value="" data-balance="0" data-return="0">-- Pilih Rekening --</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" 
                                data-balance="{{ $acc->balance }}" 
                                data-return="{{ $acc->depositoType->yearly_return }}">
                            {{ $acc->id }} - {{ $acc->depositoType->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
            <label>Nominal Penarikan</label>
            <input type="number" name="amount" id="withdrawAmount" min="10000" placeholder="Minimal 10.000" required>
        </div>

            <div class="calculation-area">
                <div class="calc-row">
                    <span>Saldo Awal:</span>
                    <span id="startBalanceText">Rp. 0</span>
                </div>
                <div class="calc-row">
                    <span>Bunga Didapat (1 bln):</span>
                    <span id="interestText" style="color: #28a745;">+ Rp. 0</span>
                </div>
                <div class="calc-row total-bold">
                    <span>Total Saldo Akhir:</span>
                    <span id="endingBalanceText">Rp. 0</span>
                </div>
            </div>

            <button type="submit" class="btn-withdraw">Tarik Dana</button>
            <a href="/customer/dashboard" class="btn-cancel">Batal</a>
        </form>
    </div>

    <script>
        const accountSelect = document.getElementById('accountSelect');
        const withdrawAmountInput = document.getElementById('withdrawAmount');
        
        const startBalanceText = document.getElementById('startBalanceText');
        const interestText = document.getElementById('interestText');
        const endingBalanceText = document.getElementById('endingBalanceText');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }

        function calculateEndingBalance() {
            const selectedOption = accountSelect.options[accountSelect.selectedIndex];
            const startingBalance = parseFloat(selectedOption.getAttribute('data-balance')) || 0;
            const yearlyReturn = parseFloat(selectedOption.getAttribute('data-return')) || 0;
            const withdrawAmount = parseFloat(withdrawAmountInput.value) || 0;

            // Ending Balance = Starting Balance + Bunga (1 bulan) - Nominal Tarik
            // Rumus Bunga: (Starting Balance * (Yearly Return / 100)) / 12
            const monthlyReturn = (startingBalance * (yearlyReturn / 100)) / 12;
            const endingBalance = startingBalance + monthlyReturn - withdrawAmount;

            startBalanceText.innerText = formatRupiah(startingBalance);
            interestText.innerText = "+ " + formatRupiah(monthlyReturn);
            endingBalanceText.innerText = formatRupiah(endingBalance);

            // Validasi jika saldo tidak cukup
            if (endingBalance < 0) {
                endingBalanceText.style.color = 'red';
            } else {
                endingBalanceText.style.color = '#222';
            }
        }

        accountSelect.addEventListener('change', calculateEndingBalance);
        withdrawAmountInput.addEventListener('input', calculateEndingBalance);
    </script>
</body>
</html>