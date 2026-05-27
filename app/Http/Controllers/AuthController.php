<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login'); // Nanti dibuat oleh Anggota 2 (Frontend)
    }

    // Memproses data email & password yang dikirim dari form
    public function login(Request $request)
    {
        // 1. Validasi inputan
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek kecocokan dengan database menggunakan Auth::attempt
        if (Auth::attempt($credentials)) {
            // Jika cocok, buat sesi login dan arahkan ke dashboard admin
            $request->session()->regenerate();
            return redirect()->intended('admin/cars')->with('success', 'Selamat datang kembali, Admin!');
        }

        // 3. Jika salah password/email, kembalikan ke halaman login bawa pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses log out
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil log out.');
    }
}