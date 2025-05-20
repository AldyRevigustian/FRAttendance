<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with(['mahasiswa', 'kelas', 'mataKuliah'])->get();
        return view('admin.absensi.index', compact('absensis'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $matakuliah = MataKuliah::all();
        return view('admin.absensi.create', compact('kelas', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $env_path = realpath(__DIR__ . '../../../../../.env');
        $env_path = str_replace('\\', '/', $env_path);

        $project_path = realpath(__DIR__ . '../../../../../scripts');
        $project_path = str_replace('\\', '/', $project_path);

        $python_path = trim(shell_exec('where python'));
        $python_path = str_replace('\\', '/', $python_path);

        $class_id = $request->kelas_id;
        $class_name = Kelas::findOrFail($class_id)->nama;
        $course_id = $request->matakuliah_id;
        $course_name = MataKuliah::findOrFail($course_id)->nama;

        $script_path = $project_path . '/main.py';

        $command = [
            'C:/Program Files/Git/bin/bash.exe',
            '-c',
            sprintf(
                '%s %s --selected_class_id %d --selected_class_name "%s" --selected_course_id %d --selected_course_name "%s" --project_path "%s" --env_path "%s" &',
                $python_path,
                $script_path,
                $class_id,
                $class_name,
                $course_id,
                $course_name,
                $project_path,
                $env_path
            )
        ];

        $process = new Process($command);
        try {
            $process->mustRun();
            return redirect()->route('admin.absensi')->with('success', 'Mesin Absensi Berhasil Berjalan ');
        } catch (ProcessFailedException $exception) {
            return redirect()->route('admin.absensi')->with('error', 'Mesin Absensi Gagal Berjalan ');
        }
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi')->with('success', 'Absensi berhasil dihapus');
    }
}
