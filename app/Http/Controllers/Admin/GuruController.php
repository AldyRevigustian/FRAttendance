<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:gurus,kode',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:gurus,email',
            'jenis_kelamin' => 'required|in:0,1',
            'password' => 'required|string|min:8',
        ]);

        $guru = Guru::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => $request->password,
        ]);
        if ($guru) {
            return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan');
        }
        return redirect()->route('admin.guru')->with('failed', 'Guru gagal ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:255|unique:gurus,kode,' . $guru->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:gurus,email,' . $guru->id,
            'jenis_kelamin' => 'required|in:0,1',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $update = $guru->update($data);

        if ($update) {
            return redirect()->route('admin.guru')->with('success', 'Guru berhasil diperbarui');
        }

        return redirect()->route('admin.guru')->with('failed', 'Guru gagal diperbarui');
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
