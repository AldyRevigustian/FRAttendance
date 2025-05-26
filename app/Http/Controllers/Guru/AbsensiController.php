<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index($kelas_terpilih)
    {
        $kelas = Kelas::findOrFail($kelas_terpilih);
        $absensis = Absensi::with(['siswa', 'kelas'])->where('kelas_id', $kelas_terpilih)->get();
        return view('guru.absensi.index', compact('absensis', 'kelas'));
    }

    public function create($kelas_terpilih)
    {
        $nama_kelas = Kelas::findOrFail($kelas_terpilih)->nama;
        $siswas = Siswa::where('kelas_id', $kelas_terpilih)->get();
        $kelas = Kelas::all();
        return view('guru.absensi.create', compact('siswas', 'kelas', 'nama_kelas'));
    }

    public function store(Request $request, $kelas_terpilih)
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
            return redirect()->route('guru.absensi', ['kelas_terpilih' => $kelas_terpilih])
                ->with('success', 'Absensi berhasil ditambahkan');
        }

        return redirect()->route('guru.absensi', ['kelas_terpilih' => $kelas_terpilih])
            ->with('failed', 'Absensi gagal ditambahkan');
    }

    public function edit($kelas_terpilih, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $siswas = Siswa::where('kelas_id', $kelas_terpilih)->get();
        $kelas = Kelas::where('id', $kelas_terpilih)->first();
        return view('guru.absensi.edit', compact('absensi', 'siswas', 'kelas'));
    }

    public function update(Request $request, $kelas_terpilih, $id)
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

        return redirect()->route('guru.absensi',  ['kelas_terpilih' => $kelas_terpilih])->with('success', 'Absensi berhasil diperbarui');
    }

    public function destroy($kelas_terpilih, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('guru.absensi',  ['kelas_terpilih' => $kelas_terpilih])->with('success', 'Absensi berhasil dihapus');
    }
}
