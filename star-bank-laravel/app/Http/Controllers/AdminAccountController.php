<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use App\Models\DepositoType; 

class AdminAccountController extends Controller
{
    // 1. Menampilkan Halaman Tabel Rekening
    public function accountIndex()
    {
        $accounts = Account::with(['customer', 'depositoType'])->get();
        return view('admin.account', compact('accounts'));
    }

    // 2. Menampilkan Form Buka Rekening Baru
    public function create()
    {
        $customers = User::where('id', 'like', 'CST-%')->get();
        $depositoTypes = DepositoType::all();
        
        return view('admin.account_create', compact('customers', 'depositoTypes'));
    }

    // 3. Menampilkan Form Edit Rekening
    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $depositoTypes = DepositoType::all(); 
        
        return view('admin.account_edit', compact('account', 'depositoTypes'));
    }

    // 4. Simpan Rekening Baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'deposito_type_id' => 'required|exists:deposito_types,id',
            'balance' => 'required|numeric|min:0'
        ]);

        $lastAccount = Account::orderBy('id', 'desc')->first();
        $newNumber = $lastAccount ? intval(substr($lastAccount->id, 4)) + 1 : 1;
        $newId = 'ACC-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Account::create([
            'id' => $newId,
            'customer_id' => $request->customer_id,
            'deposito_type_id' => $request->deposito_type_id,
            'balance' => $request->balance
        ]);

        return redirect('/admin/account')->with('success', 'Rekening berhasil dibuka');
    }

    // 5. Update Rekening
    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect('/admin/account')->with('error', 'Rekening tidak ditemukan');
        }

        $request->validate([
            'deposito_type_id' => 'sometimes|required|exists:deposito_types,id',
            'balance' => 'sometimes|required|numeric|min:0'
        ]);

        if ($request->has('deposito_type_id')) {
            $account->deposito_type_id = $request->deposito_type_id;
        }
        if ($request->has('balance')) {
            $account->balance = $request->balance;
        }

        $account->save();

        return redirect('/admin/account')->with('success', 'Data Rekening berhasil diperbarui');
    }

    // 6. Hapus Rekening
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect('/admin/account')->with('error', 'Rekening tidak ditemukan');
        }

        $account->delete();

        return redirect('/admin/account')->with('success', 'Rekening berhasil ditutup');
    }

    public function index()
    {
        $accounts = Account::with(['customer', 'depositoType'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Rekening berhasil diambil',
            'data' => $accounts
        ], 200);
    }
}