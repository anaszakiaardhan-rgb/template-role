<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupController extends Controller
{
    /**
     * Set up default permissions for the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function setupPermissions()
    {
        // Buat permission dasar
        $permissions = [
            'manage-users',
            'create-user',
            'edit-user',
            'delete-user',
            'view-users',
            'manage-roles',
            'create-role',
            'edit-role',
            'delete-role',
            'view-roles',
            'manage-permissions',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'view-permissions',
            'assign-permissions',
        ];
        
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
        
        // Buat role super admin
        $superAdminRole = Role::findOrCreate('super admin', 'web');
        $superAdminRole->syncPermissions(Permission::all());
        
        // Buat role admin
        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions([
            'manage-users', 'create-user', 'edit-user', 'delete-user', 'view-users',
            'view-roles', 'view-permissions'
        ]);
        
        // Buat role moderator
        $moderatorRole = Role::findOrCreate('moderator', 'web');
        $moderatorRole->syncPermissions([
            'view-users', 'view-roles', 'view-permissions'
        ]);
        
        return redirect()->route('roles.index')
            ->with('success', 'Default permissions dan roles berhasil dibuat.');
    }
}