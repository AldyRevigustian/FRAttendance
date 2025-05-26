<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;

class GuruAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_guru');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'kelas_id' => ['required', 'exists:kelas,id'],
        ]);

        if (Auth::guard('guru')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            $guru = Auth::guard('guru')->user();

            $kelas = Kelas::where('id', $credentials['kelas_id'])
                ->where('guru_id', $guru->id)
                ->first();

            if (!$kelas) {
                Auth::guard('guru')->logout();
                return back()->withErrors([
                    'kelas_id' => 'Kelas yang dipilih tidak valid untuk akun ini.',
                ]);
            }

            session(['kelas_aktif' => $kelas->id]);

            return redirect()->route('guru.dashboard', ['kelas_terpilih' => $kelas->id]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('guru')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('guru.login');
    }
}
