<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessUnit;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('businessUnit')->orderBy('name')->get();
            $businessUnits = BusinessUnit::where('is_active', true)->orderBy('nama')->get();
            $roles = Role::where('is_active', true)->orderBy('nama')->get();
        } catch (Exception $e) {
            $users = collect();
            $businessUnits = collect();
            $roles = collect();
        }
        return view('master.users', compact('users', 'businessUnits', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'business_unit_id' => 'nullable|exists:business_units,id',
            'jabatan' => 'nullable|max:100',
            'role' => 'required',
        ]);
        $data['business_unit_id'] = $data['business_unit_id'] ?? null;
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = true;
        User::create($data);
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'business_unit_id' => 'nullable|exists:business_units,id',
            'jabatan' => 'nullable|max:100',
            'role' => 'required',
        ]);

        $data['business_unit_id'] = $data['business_unit_id'] ?? null;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->back()->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return redirect()->back()->with('success', 'Status user berhasil diupdate');
    }
}