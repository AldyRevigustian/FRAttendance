<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class TrainingController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        return view('admin.training.index', compact('siswas'));
    }

    public function store()
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
}
