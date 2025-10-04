<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index() 
     {
        $data = Dosen::all();
        return view('dosen.index', compact('data'));
    }

    public function store(Request $request)
    {
        Dosen::create($request->only('nama','nid'));
        return redirect()->back();
    }
 // ✅ Edit
    public function edit($id)
    {
        $dsn = Dosen::findOrFail($id);
        return view('dosen.edit', compact('dsn'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nid'  => 'required'
        ]);

        $dsn = Dosen::findOrFail($id);
        $dsn->update($request->only('nama','nid'));

        return redirect()->route('dosen.index')->with('success','Data berhasil diupdate!');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $dsn = Dosen::findOrFail($id);
        $dsn->delete();

        return redirect()->route('dosen.index')->with('success','Data berhasil dihapus!');
    }
}
