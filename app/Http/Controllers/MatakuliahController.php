<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $data = Matakuliah::all();
        return view('matakuliah.index', compact('data'));
    }

    public function store(Request $request)
    {
        Matakuliah::create($request->only('nama_matakuliah', 'deskripsi'));
        return redirect()->back();
    }

    // ✅ Edit
    public function edit($id)
    {
        $matkul = Matakuliah::findOrFail($id);
        return view('matakuliah.edit', compact('matkul'));
    }


 // ✅ Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_matakuliah' => 'required',
            'deskripsi'  => 'required'
        ]);

        $matkul = Matakuliah::findOrFail($id);
        $matkul->update($request->only('nama_matakuliah','deskripsi'));

        return redirect()->route('matakuliah.index')->with('success','Data berhasil diupdate!');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $matkul= Matakuliah::findOrFail($id);
        $matkul->delete();

        return redirect()->route('matakuliah.index')->with('success','Data berhasil dihapus!');
    }
}


