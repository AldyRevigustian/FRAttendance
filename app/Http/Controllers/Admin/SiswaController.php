<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiswaController extends Controller
{
    public function verify(Request $request)
    {
        $photos = $request->input('photos');

        $tempFiles = [];
        foreach ($photos as $index => $photo) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
            $filePath = storage_path("app/temp_photo_{$index}.jpg");
            file_put_contents($filePath, $imageData);
            $tempFiles[] = $filePath;
        }

        $pythonScript = base_path('scripts/verify_faces.py');
        $command = escapeshellcmd("python $pythonScript " . implode(' ', $tempFiles));
        $output = shell_exec($command);
        $result = json_decode($output, true);

        foreach ($tempFiles as $file) {
            unlink($file);
        }

        return response()->json($result);
    }


    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function train()
    {
        $pythonScript1 = base_path('scripts/augmentasi.py');
        $pythonScript2 = base_path('scripts/train.py');

        $command1 = "python $pythonScript1";
        $command2 = "python $pythonScript2";

        exec($command1, $output1, $status1);
        exec($command2, $output2, $status2);

        if ($status1 === 0 && $status2 === 0) {
            Siswa::query()->update(['is_trained' => 1]);
            return redirect()->route('admin.training')->with('success', 'Training Siswa berhasil ');
        } else {
            return redirect()->route('admin.training')->with('error', 'Terjadi kesalahan saat Training');
        }
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:0,1',
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $path = base_path("scripts/Images/{$id}/");
        $path2 = base_path("scripts/Images/Augmented_Images/{$id}/");

        if (File::exists($path) && File::isDirectory($path)) {
            File::deleteDirectory($path);
        }

        if (File::exists($path2) && File::isDirectory($path2)) {
            File::deleteDirectory($path2);
        }
        $siswa->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus');
    }
}
