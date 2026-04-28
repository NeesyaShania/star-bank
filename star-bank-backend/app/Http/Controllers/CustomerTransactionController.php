<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CustomerTransactionController extends Controller
{
    // 1. SETOR TUNAI (DEPOSIT)
    public function deposit(Request $request)
    {
        // 1. Validasi Input (Minimal Rp 10.000)
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:10000'
        ]);

        // 2. Cari Rekening
        $account = Account::find($request->account_id);

        // 3. Menambahkan Saldo
        $account->balance += $request->amount;
        $account->save();

        // 4. Mencatat ke tabel Transactions
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'transaction_type' => 'deposit',
            'amount' => $request->amount,
            'transaction_date' => now(),
            'interest_amount' => 0 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Setor tunai berhasil',
            'data' => [
                'transaction' => $transaction,
                'current_balance' => $account->balance
            ]
        ], 200);
    }

    // 2. TARIK TUNAI (WITHDRAW) 
    public function withdraw(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $account = Account::with('depositoType')->find($request->account_id);
                
                if (!$account) {
                    return response()->json(['success' => false, 'message' => 'Akun tidak ditemukan'], 404);
                }

                $amount = (float) $request->amount;
                if ($account->balance < $amount) {
                    return response()->json(['success' => false, 'message' => 'Saldo tidak mencukupi'], 400);
                }

                // 1. Hitung Bunga
                $rate = $account->depositoType->yearly_return ?? 0;
                $bonusBunga = ($account->balance * ($rate / 100)) / 12;

                // 2. Potong Saldo 
                $account->balance = $account->balance - $amount + $bonusBunga;
                $account->save();

                // 3. Simpan Riwayat
                Transaction::create([
                    'account_id'       => $account->id,
                    'transaction_type' => 'withdraw',
                    'amount'           => $amount,
                    'transaction_date' => $request->transaction_date ?? now()->format('Y-m-d'),
                    'interest_amount'  => $bonusBunga
                ]);

                return response()->json(['success' => true]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        });
    }

    public function getDashboardData($id)
    {
        try {
            $accounts = \App\Models\Account::with('depositoType')
                ->where('customer_id', $id)
                ->get();

            $accountIds = $accounts->pluck('id');

            $transactions = \App\Models\Transaction::whereIn('account_id', $accountIds)
                ->select('id', 'account_id', 'transaction_type', 'amount', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'accounts' => $accounts,
                'transactions' => $transactions
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}