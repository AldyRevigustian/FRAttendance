<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = Guru::all();
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        Kelas::create($request->all());
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gurus = Guru::all();
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id)->update($request->all());
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id)->delete();

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus.');
    }
}
