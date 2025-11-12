<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
<<<<<<< HEAD
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');  //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }
=======
    /** IDs protegidos: 1..4 */
    protected function isProtected(Role $role): bool
    {
        return (int) $role->id <= 4;
    }

    public function index() { return view('admin.roles.index'); }

    public function create() { return view('admin.roles.create'); }
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        session() ->flash('swal',
            [
                'icon'=>'success',
                'title'=>'Role Created Successfully',
                'text'=>'el rola ha sido creado'

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
=======
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create(['name' => $data['name'], 'guard_name' => 'web']);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Rol creado',
            'text'  => 'El rol se creó correctamente.',
        ]);

        return redirect()->route('admin.roles.index');
    }

>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
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
<<<<<<< HEAD
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->only('name'));

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
=======
        $role = Role::findOrFail($id);

        if ($this->isProtected($role)) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'Acción no permitida',
                'text'  => 'Este rol no puede modificarse.',
            ]);
            return redirect()->route('admin.roles.index');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        if ($role->name === $request->name) {
            session()->flash('swal', [
                'icon'  => 'info',
                'title' => 'Sin cambios',
                'text'  => 'No se detectaron modificaciones.',
            ]);
            return redirect()->route('admin.roles.edit', $role);
        }

        $role->update(['name' => $request->name]);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Rol actualizado',
            'text'  => 'El rol se actualizó correctamente.',
        ]);

        return redirect()->route('admin.roles.index');
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
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
}
