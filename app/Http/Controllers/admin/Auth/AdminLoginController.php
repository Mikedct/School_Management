<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        if (session()->has('adminID')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'adminEmail' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'adminEmail.required' => 'Email wajib diisi',
            'adminEmail.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Ambil admin berdasarkan email
        $admin = DB::table('admin')
            ->where('adminEmail', $request->adminEmail)
            ->first();

        // Jika email tidak ditemukan
        if (!$admin) {
            return back()
                ->withErrors(['login' => 'Email tidak ditemukan'])
                ->withInput($request->only('adminEmail'));
        }

        $inputPassword = md5($request->password);

        if ($inputPassword !== $admin->password) {
            return back()
                ->withErrors(['login' => 'Password salah'])
                ->withInput($request->only('adminEmail'));
        }

        // Simpan session
        session([
            'adminID' => $admin->adminID,
            'adminName' => $admin->adminName,
            'adminEmail' => $admin->adminEmail,
            'isLoggedIn' => true,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Login berhasil!');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.auth.login')
            ->with('success', 'Logout berhasil!');
    }
}