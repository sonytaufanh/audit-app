<?php

namespace App\Http\Controllers;

use App\Models\KategoriRisiko;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class KategoriRisikoController extends Controller
{
    public function index()
    {
        try {
            $kategoriRisikos = KategoriRisiko::orderBy('nama')->get();
        } catch (Exception $e) {
            $kategoriRisikos = collect();
        }
        return view('master.kategori_risiko', compact('kategoriRisikos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = DocumentCodeService::generate(KategoriRisiko::class);
        $data['nama'] = ucwords($data['nama']);
        KategoriRisiko::create($data + ['is_active' => true]);
        return redirect()->back()->with('success', 'Kategori risiko berhasil ditambahkan');
    }

    public function update(Request $request, KategoriRisiko $kategoriRisiko)
    {
        $data = $request->validate([
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $kategoriRisiko->update($data);
        return redirect()->back()->with('success', 'Kategori risiko berhasil diupdate');
    }

    public function destroy(KategoriRisiko $kategoriRisiko)
    {
        $kategoriRisiko->delete();
        return redirect()->back()->with('success', 'Kategori risiko berhasil dihapus');
    }
}