<?php

namespace App\Http\Controllers;

use App\Models\RiskRegister;
use App\Models\Departemen;
use App\Models\KategoriRisiko;
use App\Models\User;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class RiskRegisterController extends Controller
{
    public function index()
    {
        try {
            $riskRegisters = RiskRegister::with(['departemen', 'kategoriRisiko', 'riskOwner'])
                ->orderBy('risk_score', 'desc')->get();
            $departemens = Departemen::where('is_active', true)->orderBy('nama')->get();
            $kategoriRisikos = KategoriRisiko::where('is_active', true)->orderBy('nama')->get();
            $users = User::orderBy('name')->get();
        } catch (Exception $e) {
            $riskRegisters = collect();
            $departemens = collect();
            $kategoriRisikos = collect();
            $users = collect();
        }
        return view('risk.register', compact('riskRegisters', 'departemens', 'kategoriRisikos', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'kategori_risiko_id' => 'required|exists:kategori_risikos,id',
            'impact_score' => 'required|integer|min:1|max:5',
            'probability_score' => 'required|integer|min:1|max:5',
            'penyebab' => 'nullable',
            'dampak' => 'nullable',
            'mitigasi' => 'nullable',
            'risk_owner_id' => 'nullable|exists:users,id',
            'tanggal_identifikasi' => 'required|date',
        ]);
        $data['kode'] = DocumentCodeService::generate(RiskRegister::class);
        $data['nama'] = ucwords($data['nama']);
        $data['risk_owner_id'] = $data['risk_owner_id'] ?? null;

        $data['risk_score'] = $data['impact_score'] * $data['probability_score'];
        $data['risk_level'] = $this->calculateRiskLevel($data['risk_score']);
        $data['status'] = 'identified';

        RiskRegister::create($data);
        return redirect()->back()->with('success', 'Risk register berhasil ditambahkan');
    }

    public function update(Request $request, RiskRegister $riskRegister)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'kategori_risiko_id' => 'required|exists:kategori_risikos,id',
            'impact_score' => 'required|integer|min:1|max:5',
            'probability_score' => 'required|integer|min:1|max:5',
            'penyebab' => 'nullable',
            'dampak' => 'nullable',
            'mitigasi' => 'nullable',
            'status' => 'required',
            'risk_owner_id' => 'nullable|exists:users,id',
            'tanggal_identifikasi' => 'required|date',
            'tanggal_review' => 'nullable|date',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $data['risk_owner_id'] = $data['risk_owner_id'] ?? null;

        $data['risk_score'] = $data['impact_score'] * $data['probability_score'];
        $data['risk_level'] = $this->calculateRiskLevel($data['risk_score']);

        $riskRegister->update($data);
        return redirect()->back()->with('success', 'Risk register berhasil diupdate');
    }

    public function destroy(RiskRegister $riskRegister)
    {
        $riskRegister->delete();
        return redirect()->back()->with('success', 'Risk register berhasil dihapus');
    }

    public function heatMap()
    {
        try {
            $risks = RiskRegister::with(['departemen', 'kategoriRisiko'])
                ->where('status', '!=', 'closed')
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'kode' => $r->kode,
                        'nama' => $r->nama,
                        'impact' => $r->impact_score,
                        'probability' => $r->probability_score,
                        'risk_level' => $r->risk_level,
                        'departemen' => $r->departemen->nama ?? '-',
                    ];
                });
        } catch (Exception $e) {
            $risks = collect();
        }

        return view('risk.heat_map', compact('risks'));
    }

    private function calculateRiskLevel($score)
    {
        if ($score >= 20) return 'critical';
        if ($score >= 15) return 'high';
        if ($score >= 8) return 'medium';
        return 'low';
    }
}