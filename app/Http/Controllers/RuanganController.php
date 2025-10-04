<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index() {
    $data = Ruangan::all();
    return view('ruangan.index', compact('data'));
}

public function store(Request $request) {
    Ruangan::create($request->only('nama_ruangan', 'kapasitas'));
    return redirect()->back();
}
// ✅ Edit
    public function edit($id)
    {
        $ruang = Ruangan::findOrFail($id);
        return view('ruangan.edit', compact('ruang'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas'  => 'required'
        ]);

        $ruang = Ruangan::findOrFail($id);
        $ruang->update($request->only('nama_ruangan','kapasitas'));

        return redirect()->route('ruangan.index')->with('success','Data berhasil diupdate!');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $ruang = Ruangan::findOrFail($id);
        $ruang->delete();

        return redirect()->route('ruangan.index')->with('success','Data berhasil dihapus!');
    }
}
