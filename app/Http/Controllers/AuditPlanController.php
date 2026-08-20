<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class AuditPlanController extends Controller
{
    public function index()
    {
        try {
            $auditPlans = AuditPlan::with('creator')->orderBy('tahun', 'desc')->orderBy('tanggal_mulai', 'desc')->get();
        } catch (Exception $e) {
            $auditPlans = collect();
        }
        return view('audit.plan', compact('auditPlans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'tahun' => 'required|integer|min:2020|max:2100',
            'periode' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'anggaran' => 'nullable|numeric|min:0',
        ]);
        $data['kode'] = DocumentCodeService::generate(AuditPlan::class);
        $data['nama'] = ucwords($data['nama']);
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';
        AuditPlan::create($data);
        return redirect()->back()->with('success', 'Audit plan berhasil ditambahkan');
    }

    public function update(Request $request, AuditPlan $auditPlan)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'tahun' => 'required|integer|min:2020|max:2100',
            'periode' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'anggaran' => 'nullable|numeric|min:0',
            'status' => 'required',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $auditPlan->update($data);
        return redirect()->back()->with('success', 'Audit plan berhasil diupdate');
    }

    public function destroy(AuditPlan $auditPlan)
    {
        $auditPlan->delete();
        return redirect()->back()->with('success', 'Audit plan berhasil dihapus');
    }
}