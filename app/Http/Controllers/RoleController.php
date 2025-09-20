<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name',
            ]);

            // Log untuk debugging
            \Log::info('Creating new role: ' . $request->name);
            
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            
            \Log::info('Role created successfully with ID: ' . $role->id);

            // Jika ada permission yang dipilih, tetapkan ke role
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
                $role->syncPermissions($permissions);
                \Log::info('Permissions assigned to role: ', $permissions);
            }

            return redirect()->route('roles.edit', $role->id)
                ->with('success', 'Role berhasil dibuat. Silahkan tambahkan permission untuk role ini.');
        } catch (\Exception $e) {
            \Log::error('Error creating role: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()->with('error', 'Terjadi kesalahan saat membuat role: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Nama role berhasil diperbarui');
    }
    
    /**
     * Update permissions for a role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        try {
            // Validasi input
            $permissionIds = $request->permissions ?? [];
            
            // Log untuk debugging
            \Log::info('Updating permissions for role: ' . $role->name);
            \Log::info('Permission IDs: ', $permissionIds);
            
            // Ambil nama permission berdasarkan ID
            $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            
            // Log nama permission yang akan di-sync
            \Log::info('Permission names to sync: ', $permissions);
            
            // Sync permissions ke role
            $role->syncPermissions($permissions);
            
            return back()->with('success', 'Permission untuk role ' . $role->name . ' berhasil diperbarui');
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error updating permissions: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()->with('error', 'Terjadi kesalahan saat memperbarui permission: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}