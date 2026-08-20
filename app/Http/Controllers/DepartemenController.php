<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Exception;

class DepartemenController extends Controller
{
    public function index()
    {
        try {
            $departemens = Departemen::orderBy('nama')->get();
        } catch (Exception $e) {
            $departemens = collect();
        }
        return view('master.departemen', compact('departemens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:departemens|max:3',
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        Departemen::create($data + ['is_active' => true]);
        return redirect()->back()->with('success', 'Departemen berhasil ditambahkan');
    }

    public function update(Request $request, Departemen $departemen)
    {
        $data = $request->validate([
            'kode' => 'required|unique:departemens,kode,' . $departemen->id . '|max:3',
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        $departemen->update($data);
        return redirect()->back()->with('success', 'Departemen berhasil diupdate');
    }

    public function destroy($id)
    {
        $departemen = Departemen::withoutGlobalScope('business_unit')->findOrFail($id);
        $departemen->delete();
        return redirect()->back()->with('success', 'Departemen berhasil dihapus');
    }
}