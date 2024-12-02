<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(Request $request)
    {

        $roles = Role::all();

        return view('roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $roles = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('roles.index')
            ->with('success_message', 'Berhasil menambah Jabatan baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error_message', 'Role Tidak Ditemukan');
        }

        return view('roles.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error_message', 'Role Tidak Ditemukan');
        }

        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();

        return redirect()->route('roles.index')
            ->with('success_message', 'Berhasil menambah Mengubah Data Jabatan Baru');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error_message', 'Role Tidak Ditemukan');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success_message', 'Berhasil Menghapus Data');
    }
}