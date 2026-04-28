<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    // 1. Menampilkan semua data Customer
    public function index()
    {
        $customers = User::where('id', 'like', 'CST-%')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Customer berhasil diambil',
            'data' => $customers
        ], 200);
    }

    // 2.Menambahkan Customer Baru
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'pin' => 'required|string|size:6'
        ]);

        // 2. Logika Pembuatan ID Otomatis (CST-XXX)
        $lastCustomer = User::where('id', 'like', 'CST-%')->orderBy('id', 'desc')->first();
        
        if ($lastCustomer) {
            $lastNumber = intval(substr($lastCustomer->id, 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $newId = 'CST-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // 3. Menyimpan ke Database
        $customer = User::create([
            'id' => $newId,
            'name' => $request->name,
            'email' => $request->email,
            'pin' => Hash::make($request->pin) 
        ]);

        // 4. Menampilkan Respon Sukses
        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil ditambahkan',
            'data' => $customer
        ], 201);
    }
    // 3. Mengubah Data Customer
   public function update(Request $request, $id)
    {
        $customer = User::where('id', $id)->where('id', 'like', 'CST-%')->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'pin' => 'nullable|string|digits:6'
        ]);

        if ($request->has('name')) {
            $customer->name = $request->name;
        }
        if ($request->has('email')) {
            $customer->email = $request->email;
        }
        if ($request->filled('pin')) {
            $customer->pin = Hash::make($request->pin);
        }

        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Customer berhasil diperbarui',
            'data' => $customer
        ], 200);
    }

    // 4. Menghapus Data Customer 
    public function destroy($id)
    {
        // 1. Cari data customer
        $customer = User::where('id', $id)->where('id', 'like', 'CST-%')->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Data Customer tidak ditemukan'
            ], 404);
        }

        // 2. Hapus data
        $customer->delete();

        // 3. Menampilkan Respon Sukses
        return response()->json([
            'success' => true,
            'message' => 'Data Customer berhasil dihapus'
        ], 200);
    }
}