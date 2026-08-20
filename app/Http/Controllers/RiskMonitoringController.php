<?php

namespace App\Http\Controllers;

use App\Models\RiskMonitoring;
use App\Models\RiskRegister;
use Illuminate\Http\Request;
use Exception;

class RiskMonitoringController extends Controller
{
    public function index()
    {
        try {
            $monitorings = RiskMonitoring::with(['riskRegister.departemen', 'reportedBy'])
                ->orderBy('tanggal', 'desc')->get();
            $riskRegisters = RiskRegister::where('status', '!=', 'closed')->orderBy('nama')->get();
        } catch (Exception $e) {
            $monitorings = collect();
            $riskRegisters = collect();
        }
        return view('risk.monitoring', compact('monitorings', 'riskRegisters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'risk_register_id' => 'required|exists:risk_registers,id',
            'tanggal' => 'required|date',
            'impact_score' => 'required|integer|min:1|max:5',
            'probability_score' => 'required|integer|min:1|max:5',
            'catatan' => 'nullable',
            'tindakan' => 'nullable',
        ]);

        $data['risk_score'] = $data['impact_score'] * $data['probability_score'];
        $data['risk_level'] = $this->calculateRiskLevel($data['risk_score']);
        $data['reported_by'] = auth()->id() ?? (\App\Models\User::first()->id ?? null);

        RiskMonitoring::create($data);
        return redirect()->back()->with('success', 'Risk monitoring berhasil ditambahkan');
    }

    public function update(Request $request, RiskMonitoring $riskMonitoring)
    {
        $data = $request->validate([
            'risk_register_id' => 'required|exists:risk_registers,id',
            'tanggal' => 'required|date',
            'impact_score' => 'required|integer|min:1|max:5',
            'probability_score' => 'required|integer|min:1|max:5',
            'catatan' => 'nullable',
            'tindakan' => 'nullable',
        ]);

        $data['risk_score'] = $data['impact_score'] * $data['probability_score'];
        $data['risk_level'] = $this->calculateRiskLevel($data['risk_score']);

        $riskMonitoring->update($data);
        return redirect()->back()->with('success', 'Risk monitoring berhasil diupdate');
    }

    public function destroy(RiskMonitoring $riskMonitoring)
    {
        $riskMonitoring->delete();
        return redirect()->back()->with('success', 'Risk monitoring berhasil dihapus');
    }

    private function calculateRiskLevel($score)
    {
        if ($score >= 20) return 'critical';
        if ($score >= 15) return 'high';
        if ($score >= 8) return 'medium';
        return 'low';
    }
}