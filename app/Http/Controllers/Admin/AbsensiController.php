<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with(['siswa', 'kelas'])->get();
        return view('admin.absensi.index', compact('absensis'));
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi')->with('success', 'Absensi berhasil dihapus');
    }
}
