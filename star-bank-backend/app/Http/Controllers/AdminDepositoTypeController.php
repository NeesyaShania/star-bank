<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepositoType;

class AdminDepositoTypeController extends Controller
{
    // 1. Menampilkan semua Tipe Deposito
    public function index()
    {
        $depositoTypes = DepositoType::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Tipe Deposito berhasil diambil',
            'data' => $depositoTypes
        ], 200);
    }

    // 2. Menambahkan Tipe Deposito Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'yearly_return' => 'required|numeric|min:0'
        ]);

        $lastType = DepositoType::orderBy('id', 'desc')->first();
        $newNumber = $lastType ? intval(substr($lastType->id, 4)) + 1 : 1;
        $newId = 'DEP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $depositoType = DepositoType::create([
            'id' => $newId,
            'name' => $request->name,
            'yearly_return' => $request->yearly_return
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipe Deposito berhasil ditambahkan',
            'data' => $depositoType
        ], 201);
    }

    // 3. Memperbarui Data Tipe Deposito
    public function update(Request $request, $id)
    {
        $depositoType = DepositoType::find($id);

        if (!$depositoType) {
            return response()->json(['success' => false, 'message' => 'Tipe Deposito tidak ditemukan'], 404);
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

        return response()->json([
            'success' => true,
            'message' => 'Data Tipe Deposito berhasil diperbarui',
            'data' => $depositoType
        ], 200);
    }

    // 4. Menghapus Tipe Deposito
    public function destroy($id)
    {
        $depositoType = DepositoType::find($id);

        if (!$depositoType) {
            return response()->json(['success' => false, 'message' => 'Tipe Deposito tidak ditemukan'], 404);
        }

        $depositoType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tipe Deposito berhasil dihapus'
        ], 200);
    }
}