<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|string|size:6'
        ]);

        // 2. Cari User berdasarkan Email
        $user = User::where('email', $request->email)->first();

        // 3. Cek Kredensial 
        if (!$user || !Hash::check($request->pin, $user->pin)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password tidak valid'
            ], 401);
        }

        // 4. Logika Role-Based Access Control
        $role = str_contains($user->email, 'admin') ? 'admin' : 'customer';

        // 5. Menampilkan Response
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role
            ]
        ], 200);
    }
}