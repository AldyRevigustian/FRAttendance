<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index($kelas_terpilih)
    {
        $siswas = Siswa::where('kelas_id', $kelas_terpilih)->get();
        $kelas = Kelas::findOrFail($kelas_terpilih);

        return view('guru.siswa.index', compact('siswas', 'kelas'));
    }

    public function show($kelas_terpilih, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::findOrFail($kelas_terpilih);

        return view('guru.siswa.show', compact('siswa', 'kelas'));
    }
}
