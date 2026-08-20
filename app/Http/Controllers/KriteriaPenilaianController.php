<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenilaian;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class KriteriaPenilaianController extends Controller
{
    public function index()
    {
        try {
            $kriteriaPenilaians = KriteriaPenilaian::orderBy('tipe')->orderBy('nilai')->get();
        } catch (Exception $e) {
            $kriteriaPenilaians = collect();
        }
        return view('master.kriteria_penilaian', compact('kriteriaPenilaians'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:100',
            'tipe' => 'required|in:impact,probability,likelihood',
            'nilai' => 'required|integer|min:1|max:5',
            'label' => 'required|max:50',
            'deskripsi' => 'nullable',
            'warna' => 'nullable|max:20',
        ]);
        $data['kode'] = DocumentCodeService::generate(KriteriaPenilaian::class);
        $data['nama'] = ucwords($data['nama']);
        KriteriaPenilaian::create($data + ['is_active' => true]);
        return redirect()->back()->with('success', 'Kriteria penilaian berhasil ditambahkan');
    }

    public function update(Request $request, KriteriaPenilaian $kriteriaPenilaian)
    {
        $data = $request->validate([
            'nama' => 'required|max:100',
            'tipe' => 'required|in:impact,probability,likelihood',
            'nilai' => 'required|integer|min:1|max:5',
            'label' => 'required|max:50',
            'deskripsi' => 'nullable',
            'warna' => 'nullable|max:20',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $kriteriaPenilaian->update($data);
        return redirect()->back()->with('success', 'Kriteria penilaian berhasil diupdate');
    }

    public function destroy(KriteriaPenilaian $kriteriaPenilaian)
    {
        $kriteriaPenilaian->delete();
        return redirect()->back()->with('success', 'Kriteria penilaian berhasil dihapus');
    }
}