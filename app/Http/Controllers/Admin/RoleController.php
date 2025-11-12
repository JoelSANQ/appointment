<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Role Created Successfully',
            'text'  => 'El rol ha sido creado correctamente.',
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
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
        $role = Role::findOrFail($id);

        if ($this->isProtected($role)) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'Acción no permitida',
                'text'  => 'Este rol no puede modificarse.',
            ]);
            return redirect()->route('admin.roles.index');
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // ignora el ID actual para el unique
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);

        if ($this->isProtected($role)) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'Acción no permitida',
                'text'  => 'Este rol no puede modificarse.',
            ]);
            return redirect()->route('admin.roles.index');
        }

        $role->update($request->only('name'));

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($this->isProtected($role)) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'Acción no permitida',
                'text'  => 'Este rol no se puede eliminar.',
            ]);
            return redirect()->route('admin.roles.index');
        }

        $name = $role->name;
        $role->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Rol eliminado',
            'text'  => "«{$name}» se eliminó correctamente.",
        ]);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Reglas para roles protegidos (no editar / no eliminar).
     * Ajusta la lista según tus necesidades.
     */
    private function isProtected(Role $role): bool
    {
        $protegidos = [
            'admin',
            'administrator',
            'super admin',
            'super-admin',
            'root',
        ];

        return in_array(mb_strtolower($role->name), $protegidos, true);
    }
}
