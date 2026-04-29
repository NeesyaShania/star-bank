<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerTransactionController extends Controller
{
    public function index()
    {
        $id = Auth::id(); 
        
        $accounts = Account::with('depositoType')
            ->where('customer_id', $id)
            ->get();

        $accountIds = $accounts->pluck('id');

        $transactions = Transaction::whereIn('account_id', $accountIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact('accounts', 'transactions'));
    }

    // Menampilkan Form Deposit
    public function showDeposit()
    {
        $accounts = Account::where('customer_id', Auth::id())->get();
        return view('customer.deposit', compact('accounts'));
    }

    // Menampilkan Form Withdraw
    public function showWithdraw()
    {
        $accounts = Account::with('depositoType')->where('customer_id', Auth::id())->get();
        return view('customer.withdraw', compact('accounts'));
    }

    // 1. PROSES SETOR TUNAI (DEPOSIT)
    public function deposit(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:10000'
        ]);

        $account = Account::find($request->account_id);
        $account->balance += $request->amount;
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'transaction_type' => 'deposit',
            'amount' => $request->amount,
            'transaction_date' => now(),
            'interest_amount' => 0 
        ]);

        return redirect('/customer/dashboard')->with('success', 'Setor tunai berhasil');
    }

    // 2. PROSES TARIK TUNAI (WITHDRAW) 
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'account_id' => 'required'
        ], [
            'amount.min' => 'Minimal penarikan adalah Rp 10.000',
        ]);
        return DB::transaction(function () use ($request) {
            $account = Account::with('depositoType')->find($request->account_id);
            $withdrawAmount = (float) $request->amount;

            // Rumus: Bunga 1 Bulan
            $yearlyReturn = $account->depositoType->yearly_return ?? 0;
            $interestAmount = ($account->balance * ($yearlyReturn / 100)) / 12;

            // Rumus Saldo Akhir: Saldo Sekarang + Bunga - Penarikan
            $endingBalance = $account->balance + $interestAmount - $withdrawAmount;

            if ($endingBalance < 0) {
                return back()->with('error', 'Saldo tidak mencukupi setelah penarikan.');
            }

            $account->balance = $endingBalance;
            $account->save();

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'withdraw',
                'amount' => $withdrawAmount,
                'interest_amount' => $interestAmount,
                'transaction_date' => now(),
            ]);

            return redirect('/customer/dashboard')->with('success', 'Berhasil tarik dana. Saldo akhir Anda: Rp ' . number_format($endingBalance, 0, ',', '.'));
        });
    }
}