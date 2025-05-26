<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas']);

        $startDate = $request->filled('start_date') ? $request->start_date : now()->toDateString();
        $endDate = $request->filled('end_date') ? $request->end_date : now()->toDateString();

        $query->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $absensis = $query->orderBy('tanggal', 'desc')->get();
        $allKelas = Kelas::orderBy('nama')->get();

        return view('admin.absensi.index', compact('absensis', 'allKelas', 'startDate', 'endDate'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $kelas = Kelas::all();
        return view('admin.absensi.create', compact('siswas', 'kelas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => ['nullable', 'date_format:H:i', function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->waktu_masuk && strtotime($value) < strtotime($request->waktu_masuk)) {
                    $fail('Waktu keluar harus sama atau lebih besar dari waktu masuk.');
                }
            }],
        ]);

        $absensi = Absensi::create([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_keluar' => $request->waktu_keluar,
        ]);

        if ($absensi) {
            return redirect()->route('admin.absensi')->with('success', 'Absensi berhasil ditambahkan');
        }

        return redirect()->route('admin.absensi')->with('failed', 'Absensi gagal ditambahkan');
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $siswas = Siswa::all();
        $kelas = Kelas::all();
        return view('admin.absensi.edit', compact('absensi', 'siswas', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => ['nullable', 'date_format:H:i', function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->waktu_masuk && strtotime($value) < strtotime($request->waktu_masuk)) {
                    $fail('Waktu keluar harus sama atau lebih besar dari waktu masuk.');
                }
            }],
        ]);

        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'tanggal' => $request->tanggal,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_keluar' => $request->waktu_keluar,
        ]);

        return redirect()->route('admin.absensi')->with('success', 'Absensi berhasil diperbarui');
    }



    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi')->with('success', 'Absensi berhasil dihapus');
    }
}
