<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email',
            'pin'   => 'required|string|size:6'
        ]);

        // 2. Cari User berdasarkan Email
        $user = User::where('email', $request->email)->first();

        // 3. Cek Kredensial 
        if ($user && Hash::check($request->pin, $user->pin)) {
            Auth::login($user);
            $request->session()->regenerate();

            // 4. Role-Based Redirect
            if (str_contains($user->email, 'admin')) {
                return redirect('/admin/customer');
            }
            return redirect('/customer/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau PIN salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}