<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    // 1. Menampilkan Halaman Tabel Customer
    public function customerIndex()
    {
        $customers = User::where('id', 'like', 'CST-%')->get();
        return view('admin.customer', compact('customers'));
    }

    // 2. Menampilkan Form Tambah
    public function create() {
        return view('admin.customer_create');
    }

    // 3. Menampilkan Form Edit
    public function edit($id) {
        $customer = User::findOrFail($id);
        return view('admin.customer_edit', compact('customer'));
    }

    // 4. Menambahkan Customer Baru
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'pin' => 'required|string|size:6'
        ]);

        $lastCustomer = User::where('id', 'like', 'CST-%')->orderBy('id', 'desc')->first();
        
        if ($lastCustomer) {
            $lastNumber = intval(substr($lastCustomer->id, 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $newId = 'CST-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        User::create([
            'id' => $newId,
            'name' => $request->name,
            'email' => $request->email,
            'pin' => Hash::make($request->pin) 
        ]);

        return redirect('/admin/customer')->with('success', 'Customer berhasil ditambahkan');
    }

    // 5. Mengubah Data Customer
    public function update(Request $request, $id)
    {
        $customer = User::where('id', $id)->where('id', 'like', 'CST-%')->first();

        if (!$customer) {
            return redirect('/admin/customer')->with('error', 'Data tidak ditemukan');
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

        return redirect('/admin/customer')->with('success', 'Data Customer berhasil diperbarui');
    }

    // 6. Menghapus Data Customer 
    public function destroy($id)
    {
        $customer = User::where('id', $id)->where('id', 'like', 'CST-%')->first();

        if (!$customer) {
            return redirect('/admin/customer')->with('error', 'Data Customer tidak ditemukan');
        }

        $customer->delete();

        return redirect('/admin/customer')->with('success', 'Data Customer berhasil dihapus');
    }

    public function index()
    {
        $customers = User::where('id', 'like', 'CST-%')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Customer berhasil diambil',
            'data' => $customers
        ], 200);
    }
}