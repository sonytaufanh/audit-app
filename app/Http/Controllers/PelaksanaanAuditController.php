<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanAudit;
use App\Models\AuditPlan;
use App\Models\AuditUniverse;
use App\Models\User;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class PelaksanaanAuditController extends Controller
{
    public function index()
    {
        try {
            $pelaksanaanAudits = PelaksanaanAudit::with(['auditUniverse.departemen', 'auditor'])
                ->orderBy('tanggal_mulai', 'desc')->get();
            $auditPlans = AuditPlan::where('status', 'disetujui')->orderBy('nama')->get();
            $auditUniverses = AuditUniverse::where('status', 'active')->orderBy('nama')->get();
            $auditors = User::orderBy('name')->get();
        } catch (Exception $e) {
            $pelaksanaanAudits = collect();
            $auditPlans = collect();
            $auditUniverses = collect();
            $auditors = collect();
        }
        return view('audit.pelaksanaan', compact('pelaksanaanAudits', 'auditPlans', 'auditUniverses', 'auditors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'audit_plan_id' => 'nullable|exists:audit_plans,id',
            'audit_universe_id' => 'required|exists:audit_universes,id',
            'auditor_id' => 'nullable|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        ]);
        $data['kode'] = DocumentCodeService::generate(PelaksanaanAudit::class);
        $data['audit_plan_id'] = $data['audit_plan_id'] ?? null;
        $data['auditor_id'] = $data['auditor_id'] ?? null;
        $data['status'] = 'not_started';
        PelaksanaanAudit::create($data);
        return redirect()->back()->with('success', 'Pelaksanaan audit berhasil ditambahkan');
    }

    public function update(Request $request, PelaksanaanAudit $pelaksanaanAudit)
    {
        $data = $request->validate([
            'audit_plan_id' => 'nullable|exists:audit_plans,id',
            'audit_universe_id' => 'required|exists:audit_universes,id',
            'auditor_id' => 'nullable|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'status' => 'required',
            'temuan_sementara' => 'nullable',
            'realisasi_anggaran' => 'nullable|numeric|min:0',
        ]);
        $data['audit_plan_id'] = $data['audit_plan_id'] ?? null;
        $data['auditor_id'] = $data['auditor_id'] ?? null;
        $data['realisasi_anggaran'] = $data['realisasi_anggaran'] ?? 0;

        $pelaksanaanAudit->update($data);
        return redirect()->back()->with('success', 'Pelaksanaan audit berhasil diupdate');
    }

    public function destroy(PelaksanaanAudit $pelaksanaanAudit)
    {
        $pelaksanaanAudit->delete();
        return redirect()->back()->with('success', 'Pelaksanaan audit berhasil dihapus');
    }
}