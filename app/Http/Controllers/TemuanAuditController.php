<?php

namespace App\Http\Controllers;

use App\Models\TemuanAudit;
use App\Models\PelaksanaanAudit;
use App\Models\Departemen;
use App\Models\User;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class TemuanAuditController extends Controller
{
    public function index()
    {
        try {
            $temuanAudits = TemuanAudit::with(['pelaksanaanAudit.auditUniverse', 'departemen', 'assignedTo'])
                ->orderBy('tanggal_temuan', 'desc')->get();
            $pelaksanaanAudits = PelaksanaanAudit::orderBy('tanggal_mulai', 'desc')->get();
            $departemens = Departemen::where('is_active', true)->orderBy('nama')->get();
            $users = User::orderBy('name')->get();
        } catch (Exception $e) {
            $temuanAudits = collect();
            $pelaksanaanAudits = collect();
            $departemens = collect();
            $users = collect();
        }
        return view('audit.temuan', compact('temuanAudits', 'pelaksanaanAudits', 'departemens', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelaksanaan_audit_id' => 'required|exists:pelaksanaan_audits,id',
            'departemen_id' => 'required|exists:departemens,id',
            'judul' => 'required|max:200',
            'deskripsi' => 'required',
            'severity' => 'required',
            'tipe' => 'required',
            'rekomendasi' => 'nullable',
            'tanggal_temuan' => 'required|date',
            'target_closure' => 'nullable|date|after:tanggal_temuan',
            'root_cause' => 'nullable',
            'root_cause_category' => 'nullable|max:50',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $data['kode'] = DocumentCodeService::generate(TemuanAudit::class);
        $data['assigned_to'] = $data['assigned_to'] ?? null;
        $data['status'] = 'open';
        TemuanAudit::create($data);
        return redirect()->back()->with('success', 'Temuan audit berhasil ditambahkan');
    }

    public function update(Request $request, TemuanAudit $temuanAudit)
    {
        $data = $request->validate([
            'pelaksanaan_audit_id' => 'required|exists:pelaksanaan_audits,id',
            'departemen_id' => 'required|exists:departemens,id',
            'judul' => 'required|max:200',
            'deskripsi' => 'required',
            'severity' => 'required',
            'tipe' => 'required',
            'rekomendasi' => 'nullable',
            'tanggal_temuan' => 'required|date',
            'target_closure' => 'nullable|date',
            'actual_closure' => 'nullable|date',
            'status' => 'required',
            'root_cause' => 'nullable',
            'root_cause_category' => 'nullable|max:50',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $data['assigned_to'] = $data['assigned_to'] ?? null;
        $temuanAudit->update($data);
        return redirect()->back()->with('success', 'Temuan audit berhasil diupdate');
    }

    public function destroy(TemuanAudit $temuanAudit)
    {
        $temuanAudit->delete();
        return redirect()->back()->with('success', 'Temuan audit berhasil dihapus');
    }
}