<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepositoType;

class AdminDepositoTypeController extends Controller
{

    // 1. Menampilkan Halaman Tabel 
    public function depositoIndex()
    {
        $depositoTypes = DepositoType::all();
        return view('admin.deposito', compact('depositoTypes'));
    }

    // 2. Menampilkan Form Tambah
    public function create()
    {
        return view('admin.deposito_create');
    }

    // 3. Menampilkan Form Edit
    public function edit($id)
    {
        $depositoType = DepositoType::findOrFail($id);
        return view('admin.deposito_edit', compact('depositoType'));
    }


    // 4. Menambahkan Tipe Deposito Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'yearly_return' => 'required|numeric|min:0'
        ]);

        $lastType = DepositoType::orderBy('id', 'desc')->first();
        $newNumber = $lastType ? intval(substr($lastType->id, 4)) + 1 : 1;
        $newId = 'DEP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        DepositoType::create([
            'id' => $newId,
            'name' => $request->name,
            'yearly_return' => $request->yearly_return
        ]);

        return redirect('/admin/deposit')->with('success', 'Tipe Deposito berhasil ditambahkan');
    }

    // 5. Memperbarui Data Tipe Deposito
    public function update(Request $request, $id)
    {
        $depositoType = DepositoType::find($id);

        if (!$depositoType) {
            return redirect('/admin/deposit')->with('error', 'Tipe Deposito tidak ditemukan');
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'yearly_return' => 'sometimes|required|numeric|min:0'
        ]);

        if ($request->has('name')) {
            $depositoType->name = $request->name;
        }
        if ($request->has('yearly_return')) {
            $depositoType->yearly_return = $request->yearly_return;
        }

        $depositoType->save();

        return redirect('/admin/deposit')->with('success', 'Data Tipe Deposito berhasil diperbarui');
    }

    // 6. Menghapus Tipe Deposito
    public function destroy($id)
    {
        $depositoType = DepositoType::find($id);

        if (!$depositoType) {
            return redirect('/admin/deposit')->with('error', 'Tipe Deposito tidak ditemukan');
        }

        $depositoType->delete();

        return redirect('/admin/deposit')->with('success', 'Tipe Deposito berhasil dihapus');
    }

    public function index()
    {
        $depositoTypes = DepositoType::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Tipe Deposito berhasil diambil',
            'data' => $depositoTypes
        ], 200);
    }
}