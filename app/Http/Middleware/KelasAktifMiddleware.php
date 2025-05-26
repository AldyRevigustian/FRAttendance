<?php

namespace App\Http\Middleware;

use App\Models\Kelas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KelasAktifMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $kelasId = $request->route('kelas_terpilih');
        $guru = Auth::guard('guru')->user();

        if (!$kelasId || !$guru) {
            return redirect()->route('guru.login');
        }

        $kelas = Kelas::where('id', $kelasId)->where('guru_id', $guru->id)->first();

        if (!$kelas) {
            return redirect()->route('guru.login')->withErrors([
                'kelas_terpilih' => 'Kelas tidak valid atau tidak anda kelola.'
            ]);
        }

        session(['kelas_aktif' => $kelas->id]);

        return $next($request);
    }
}
