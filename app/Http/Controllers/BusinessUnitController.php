<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Exception;

class BusinessUnitController extends Controller
{
    public function index()
    {
        try {
            $businessUnits = BusinessUnit::orderBy('nama')->get();
        } catch (Exception $e) {
            $businessUnits = collect();
        }
        return view('master.business_unit', compact('businessUnits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:business_units|max:3',
            'nama' => 'required|max:100',
            'lokasi' => 'nullable|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        BusinessUnit::create($data + ['is_active' => true]);
        return redirect()->back()->with('success', 'Business Unit berhasil ditambahkan');
    }

    public function update(Request $request, BusinessUnit $businessUnit)
    {
        $data = $request->validate([
            'kode' => 'required|unique:business_units,kode,' . $businessUnit->id . '|max:3',
            'nama' => 'required|max:100',
            'lokasi' => 'nullable|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        $businessUnit->update($data);
        return redirect()->back()->with('success', 'Business Unit berhasil diupdate');
    }

    public function destroy(BusinessUnit $businessUnit)
    {
        $businessUnit->delete();
        return redirect()->back()->with('success', 'Business Unit berhasil dihapus');
    }
}