<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management Routes
// User Management Routes
Route::middleware(['auth'])->group(function () {
    // Akses ke index users memerlukan permission index-user
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:index-user')->name('users.index');
    // Akses ke create user memerlukan permission create-user
    Route::get('/users/create', [UserController::class, 'create'])->middleware('permission:create-user')->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:create-user')->name('users.store');
    // Akses ke edit dan update user memerlukan permission edit-user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('permission:edit-user')->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('permission:edit-user')->name('users.update');
    Route::patch('/users/{user}', [UserController::class, 'update'])->middleware('permission:edit-user');
    // Akses ke delete user memerlukan permission delete-user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('permission:delete-user')->name('users.destroy');
    // Show user memerlukan minimal akses index
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('permission:index-user')->name('users.show');
});

// Role & Permission Management Routes
Route::middleware(['auth'])->group(function () {
    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:view-roles')->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:create-role')->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:create-role')->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:edit-role')->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:edit-role')->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete-role')->name('roles.destroy');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('permission:view-roles')->name('roles.show');
    
    Route::put('/roles/{id}/permissions', [RoleController::class, 'updatePermissions'])
        ->name('roles.updatePermissions')
        ->middleware('permission:assign-permissions');
    
    // Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('permission:view-permissions')->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->middleware('permission:create-permission')->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('permission:create-permission')->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->middleware('permission:edit-permission')->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:edit-permission')->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:delete-permission')->name('permissions.destroy');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->middleware('permission:view-permissions')->name('permissions.show');
    
    // Old routes for backward compatibility
    Route::get('/roles-permissions', [RolePermissionController::class, 'index'])
        ->middleware('permission:view-roles')
        ->name('roles_permissions.index');
    
    // Setup Route - Jalankan sekali saat awal setup
    Route::get('/setup-permissions', [SetupController::class, 'setupPermissions'])->name('setup.permissions');
});

require __DIR__.'/auth.php';
