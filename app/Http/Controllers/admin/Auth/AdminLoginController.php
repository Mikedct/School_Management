<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('adminID')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'adminEmail' => 'required|adminEmail',
            'password' => 'required|min:6',
        ], [
            'adminEmail.required' => 'adminEmail wajib diisi',
            'adminEmail.adminEmail' => 'Format adminEmail tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Ambil admin berdasarkan adminEmail
        $admin = DB::table('admin')->where('adminEmail', $request->adminEmail)->first();

        if (!$admin) {
            return back()
                ->withErrors(['login' => 'adminEmail tidak ditemukan'])
                ->withInput($request->only('adminEmail'));
        }

        // Cek password dengan MD5
        if (md5($request->password) !== $admin->password) {
            return back()
                ->withErrors(['login' => 'Password salah'])
                ->withInput($request->only('adminEmail'));
        }

        // Simpan session admin
        session([
            'adminID' => $admin->adminID,
            'adminName' => $admin->adminName,
            'adminEmail' => $admin->adminEmail,
            'isLoggedIn' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    }

    // Logout
    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('admin.auth.login')->with('success', 'Logout berhasil!');
    }
}