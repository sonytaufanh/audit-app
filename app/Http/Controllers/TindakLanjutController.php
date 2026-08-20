<?php

namespace App\Http\Controllers;

use App\Models\TindakLanjut;
use App\Models\TemuanAudit;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class TindakLanjutController extends Controller
{
    public function index()
    {
        try {
            $tindakLanjuts = TindakLanjut::with(['temuanAudit', 'penanggungJawab', 'verifiedBy'])
                ->orderBy('tanggal_rencana', 'desc')->get();
            $temuanAudits = TemuanAudit::where('status', '!=', 'closed')->orderBy('tanggal_temuan', 'desc')->get();
            $users = User::orderBy('name')->get();
        } catch (Exception $e) {
            $tindakLanjuts = collect();
            $temuanAudits = collect();
            $users = collect();
        }
        return view('audit.tindak_lanjut', compact('tindakLanjuts', 'temuanAudits', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'temuan_audit_id' => 'required|exists:temuan_audits,id',
            'deskripsi' => 'required',
            'tanggal_rencana' => 'required|date',
            'penanggung_jawab_id' => 'nullable|exists:users,id',
        ]);

        $data['penanggung_jawab_id'] = $data['penanggung_jawab_id'] ?? null;

        $data['status'] = 'open';
        TindakLanjut::create($data);
        return redirect()->back()->with('success', 'Tindak lanjut berhasil ditambahkan');
    }

    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        $data = $request->validate([
            'temuan_audit_id' => 'required|exists:temuan_audits,id',
            'deskripsi' => 'required',
            'tanggal_rencana' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required',
            'penanggung_jawab_id' => 'nullable|exists:users,id',
            'bukti' => 'nullable',
            'catatan_verifikasi' => 'nullable',
        ]);

        $data['penanggung_jawab_id'] = $data['penanggung_jawab_id'] ?? null;

        if (in_array($data['status'], ['completed', 'verified']) && !$tindakLanjut->verified_by) {
            $data['verified_by'] = auth()->id();
            $data['verified_at'] = now();
        }

        $tindakLanjut->update($data);
        return redirect()->back()->with('success', 'Tindak lanjut berhasil diupdate');
    }

    public function destroy(TindakLanjut $tindakLanjut)
    {
        $tindakLanjut->delete();
        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus');
    }
}