<?php

namespace App\Http\Controllers;

use App\Models\KeyRiskIndicator;
use App\Models\RiskRegister;
use App\Models\Departemen;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class KeyRiskIndicatorController extends Controller
{
    public function index()
    {
        try {
            $kris = KeyRiskIndicator::with(['riskRegister', 'departemen'])->orderBy('nama')->get();
            $riskRegisters = RiskRegister::where('status', '!=', 'closed')->orderBy('nama')->get();
            $departemens = Departemen::where('is_active', true)->orderBy('nama')->get();
        } catch (Exception $e) {
            $kris = collect();
            $riskRegisters = collect();
            $departemens = collect();
        }
        return view('risk.kri', compact('kris', 'riskRegisters', 'departemens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'risk_register_id' => 'nullable|exists:risk_registers,id',
            'departemen_id' => 'required|exists:departemens,id',
            'target' => 'required|numeric',
            'current_value' => 'required|numeric',
            'threshold_min' => 'nullable|numeric',
            'threshold_max' => 'nullable|numeric',
            'satuan' => 'nullable|max:20',
            'frekuensi' => 'required',
            'last_update' => 'required|date',
        ]);
        $data['kode'] = DocumentCodeService::generate(KeyRiskIndicator::class);
        $data['nama'] = ucwords($data['nama']);
        $data['risk_register_id'] = $data['risk_register_id'] ?? null;

        $data['status'] = $this->calculateKriStatus($data);
        KeyRiskIndicator::create($data);
        return redirect()->back()->with('success', 'KRI berhasil ditambahkan');
    }

    public function update(Request $request, KeyRiskIndicator $keyRiskIndicator)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'deskripsi' => 'nullable',
            'risk_register_id' => 'nullable|exists:risk_registers,id',
            'departemen_id' => 'required|exists:departemens,id',
            'target' => 'required|numeric',
            'current_value' => 'required|numeric',
            'threshold_min' => 'nullable|numeric',
            'threshold_max' => 'nullable|numeric',
            'satuan' => 'nullable|max:20',
            'frekuensi' => 'required',
            'last_update' => 'required|date',
        ]);
        $data['risk_register_id'] = $data['risk_register_id'] ?? null;

        $data['status'] = $this->calculateKriStatus($data);
        $keyRiskIndicator->update($data);
        return redirect()->back()->with('success', 'KRI berhasil diupdate');
    }

    public function destroy(KeyRiskIndicator $keyRiskIndicator)
    {
        $keyRiskIndicator->delete();
        return redirect()->back()->with('success', 'KRI berhasil dihapus');
    }

    private function calculateKriStatus($data)
    {
        if ($data['threshold_max'] && $data['current_value'] > $data['threshold_max']) return 'red';
        if ($data['threshold_min'] && $data['current_value'] < $data['threshold_min']) return 'red';
        if ($data['threshold_max'] && $data['current_value'] > $data['threshold_max'] * 0.8) return 'yellow';
        return 'green';
    }
}