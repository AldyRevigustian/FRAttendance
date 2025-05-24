<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.guru.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:gurus,kode',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:gurus,email',
            'password' => 'required|string|min:8',
        ]);

        $guru = Guru::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if ($guru) {
            return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan');
        }
        return redirect()->route('admin.guru')->with('failed', 'Guru gagal ditambahkan');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.guru.edit', compact('guru', 'kelas'));
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        $guru->delete();

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus');
    }
}
