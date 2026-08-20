<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::orderBy('nama')->get();
        } catch (Exception $e) {
            $roles = collect();
        }
        return view('master.role', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:roles|max:3',
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        $data['can_create'] = $request->has('can_create');
        $data['can_read'] = $request->has('can_read');
        $data['can_update'] = $request->has('can_update');
        $data['can_delete'] = $request->has('can_delete');
        $data['can_approve'] = $request->has('can_approve');
        Role::create($data + ['is_active' => true]);
        return redirect()->back()->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $data = $request->validate([
            'kode' => 'required|unique:roles,kode,' . $role->id . '|max:3',
            'nama' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);
        $data['kode'] = strtoupper($data['kode']);
        $data['nama'] = ucwords($data['nama']);
        $data['can_create'] = $request->has('can_create');
        $data['can_read'] = $request->has('can_read');
        $data['can_update'] = $request->has('can_update');
        $data['can_delete'] = $request->has('can_delete');
        $data['can_approve'] = $request->has('can_approve');
        $role->update($data);
        return redirect()->back()->with('success', 'Role berhasil diupdate');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success', 'Role berhasil dihapus');
    }
}
