<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
     public function kelas(Request $request)
    {
        $guru = Auth::user(); // Mengambil user yang sedang login

        // Ambil kelas berdasarkan guru_id
        $kelas = Kelas::where('guru_id', $guru->id)->get();

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }
}
