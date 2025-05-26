<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class SiswaController extends Controller
{
    public function show($id)
    {
        $siswa = Siswa::with('kelas')
            ->where('id', $id)
            ->first();
        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        }
        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'siswa_id' => 'required|exists:siswas,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tanggal' => 'required|date',
                'waktu_masuk' => 'nullable|date_format:H:i',
                'waktu_keluar' => [
                    'nullable',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value && $request->waktu_masuk && strtotime($value) < strtotime($request->waktu_masuk)) {
                            $fail('Waktu keluar harus sama atau lebih besar dari waktu masuk.');
                        }
                    }
                ],
                'tipe_absen' => 'required|in:masuk,keluar',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }

        $existing = Absensi::where('siswa_id', $request->siswa_id)
            ->where('kelas_id', $request->kelas_id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($request->tipe_absen === 'masuk') {
            if ($existing) {
                return response()->json(['message' => 'Absensi masuk sudah ada untuk hari ini.'], 409);
            }
            $absensi = Absensi::create([
                'siswa_id' => $request->siswa_id,
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
                'waktu_masuk' => $request->waktu_masuk,
                'waktu_keluar' => null,
            ]);
            return response()->json([
                'message' => 'Absensi masuk berhasil dicatat.',
                'data' => $absensi
            ], 200);
        } else {
            if (!$existing) {
                return response()->json(['message' => 'Data absensi masuk belum ditemukan, tidak bisa absen keluar.'], 404);
            }

            if ($existing->waktu_keluar !== null) {
                return response()->json(['message' => 'Absensi keluar sudah ada untuk hari ini.'], 409);
            }

            $existing->waktu_keluar = $request->waktu_keluar;
            $existing->save();

            return response()->json([
                'message' => 'Absensi keluar berhasil diperbarui.',
                'data' => $existing
            ], 200);
        }
    }

    public function profile($id)
    {
        $path = base_path("scripts/Images/{$id}/profile.jpg");

        if (!File::exists($path)) {
            return response()->json(['message' => 'Gambar tidak ditemukan.'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        return Response::make($file, 200)->header("Content-Type", $type);
    }
}
