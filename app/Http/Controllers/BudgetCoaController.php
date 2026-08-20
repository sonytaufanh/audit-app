<?php

namespace App\Http\Controllers;

use App\Models\BudgetCoa;
use App\Models\Departemen;
use App\Services\DocumentCodeService;
use Illuminate\Http\Request;
use Exception;

class BudgetCoaController extends Controller
{
    public function index()
    {
        try {
            $budgetCoas = BudgetCoa::with('departemen')->orderBy('tahun', 'desc')->orderBy('kode_coa')->get();
            $departemens = Departemen::where('is_active', true)->orderBy('nama')->get();
        } catch (Exception $e) {
            $budgetCoas = collect();
            $departemens = collect();
        }
        return view('analytics.budget_coa', compact('budgetCoas', 'departemens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'tipe' => 'required',
            'departemen_id' => 'nullable|exists:departemens,id',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'tahun' => 'required|integer|min:2020|max:2100',
            'periode' => 'required',
            'keterangan' => 'nullable',
        ]);
        $data['kode_coa'] = DocumentCodeService::generate(BudgetCoa::class);
        $data['nama'] = ucwords($data['nama']);
        $data['departemen_id'] = $data['departemen_id'] ?? null;
        BudgetCoa::create($data);
        return redirect()->back()->with('success', 'Budget COA berhasil ditambahkan');
    }

    public function update(Request $request, BudgetCoa $budgetCoa)
    {
        $data = $request->validate([
            'nama' => 'required|max:200',
            'tipe' => 'required',
            'departemen_id' => 'nullable|exists:departemens,id',
            'anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'tahun' => 'required|integer|min:2020|max:2100',
            'periode' => 'required',
            'keterangan' => 'nullable',
        ]);
        $data['nama'] = ucwords($data['nama']);
        $data['departemen_id'] = $data['departemen_id'] ?? null;
        $budgetCoa->update($data);
        return redirect()->back()->with('success', 'Budget COA berhasil diupdate');
    }

    public function destroy(BudgetCoa $budgetCoa)
    {
        $budgetCoa->delete();
        return redirect()->back()->with('success', 'Budget COA berhasil dihapus');
    }
}