<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        return view('permissions.index', compact('permissions'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
                'name' => 'required|unique:permissions,name',
            ]);

            // Log untuk debugging
            \Log::info('Creating new permission: ' . $request->name);
            
            $permission = Permission::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            
            \Log::info('Permission created successfully with ID: ' . $permission->id);

            return redirect()->route('permissions.index')
                ->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            \Log::error('Error creating permission: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()->with('error', 'Terjadi kesalahan saat membuat permission: ' . $e->getMessage())
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
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
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
        try {
            $request->validate([
                'name' => 'required|unique:permissions,name,' . $id,
            ]);

            $permission = Permission::findOrFail($id);
            
            // Log untuk debugging
            \Log::info('Updating permission ID: ' . $id);
            \Log::info('Old permission name: ' . $permission->name);
            \Log::info('New permission name: ' . $request->name);
            
            $permission->update([
                'name' => $request->name
            ]);
            
            \Log::info('Permission updated successfully');

            return redirect()->route('permissions.index')
                ->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating permission: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()->with('error', 'Terjadi kesalahan saat memperbarui permission: ' . $e->getMessage())
                ->withInput();
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
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}