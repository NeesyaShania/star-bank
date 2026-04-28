<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AdminAccountController extends Controller
{
    // 1.Menampilkan semua Rekening 
    public function index()
    {
        // Mengambil data rekening beserta relasi nasabah dan tipe depositonya
        $accounts = Account::with(['customer', 'depositoType'])->get();

        $formattedAccounts = $accounts->map(function ($account) {
            return [
                'id' => $account->id,
                'customer_name' => $account->customer ? $account->customer->name : 'Tidak Diketahui',
                'deposito_type' => $account->depositoType ? $account->depositoType->name : 'Tidak Diketahui',
                'balance' => $account->balance,
                'created_at' => $account->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Rekening berhasil diambil',
            'data' => $accounts
        ], 200);
    }

    // 2. Membuat Rekening Baru
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

        $account = Account::create([
            'id' => $newId,
            'customer_id' => $request->customer_id,
            'deposito_type_id' => $request->deposito_type_id,
            'balance' => $request->balance
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rekening berhasil dibuka',
            'data' => $account
        ], 201);
    }

    // 3. Memperbarui Data Rekening
    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['success' => false, 'message' => 'Rekening tidak ditemukan'], 404);
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

        return response()->json([
            'success' => true,
            'message' => 'Data Rekening berhasil diperbarui',
            'data' => $account
        ], 200);
    }

    // 4. Menghapus Data Rekening
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['success' => false, 'message' => 'Rekening tidak ditemukan'], 404);
        }

        $account->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekening berhasil ditutup'
        ], 200);
    }
}