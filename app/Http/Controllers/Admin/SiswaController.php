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

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:255|unique:siswas,id',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'photos' => 'required|array|min:5',
        ]);

        $siswa = Siswa::create([
            'id' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        $folderPath = base_path("scripts/Images/{$siswa->id}");
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        foreach ($request->photos as $index => $photo) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
            $filePath = $folderPath . "/{$index}.jpg";
            file_put_contents($filePath, $imageData);
        }


        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan');
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
