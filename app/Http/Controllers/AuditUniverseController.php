<?php

namespace App\Http\Controllers;

use App\Models\AuditUniverse;
use App\Models\Departemen;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class AuditUniverseController extends Controller
{
    public function index()
    {
        try {
            $auditUniverses = AuditUniverse::with('departemen')->orderBy('nama')->get();
            $departemens = Departemen::where('is_active', true)->orderBy('nama')->get();
        } catch (Exception $e) {
            $auditUniverses = collect();
            $departemens = collect();
        }
        return view('audit.universe', compact('auditUniverses', 'departemens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'departemen_id' => 'required|exists:departemens,id',
            'tipe' => 'required',
            'risk_level' => 'required',
            'audit_frequency_months' => 'nullable|integer|min:1',
        ]);
        $data['kode'] = DocumentCodeService::generate(AuditUniverse::class);
        $data['nama'] = ucwords($data['nama']);
        AuditUniverse::create($data + ['status' => 'active']);
        return redirect()->back()->with('success', 'Audit universe berhasil ditambahkan');
    }

    public function update(Request $request, AuditUniverse $auditUniverse)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'departemen_id' => 'required|exists:departemens,id',
            'tipe' => 'required',
            'risk_level' => 'required',
            'audit_frequency_months' => 'nullable|integer|min:1',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $auditUniverse->update($data);
        return redirect()->back()->with('success', 'Audit universe berhasil diupdate');
    }

    public function destroy(AuditUniverse $auditUniverse)
    {
        $auditUniverse->delete();
        return redirect()->back()->with('success', 'Audit universe berhasil dihapus');
    }
}