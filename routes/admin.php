<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Models\Role;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
//    Route::get('users',[UserController::class, 'index'])->name('users.index');
//     Route::get('users/create',[UserController::class, 'create'])->name('users.create');
    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::get('roles/{role}/permissions', [RoleController::class, 'getPermissionsFromRoleId'])->name('roles.permissions');
    Route::get('permissions-not/{role}', [PermissionController::class, 'getPermissionsNotInRole'])->name('permission.not_in_role');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('products', ProductController::class)->names('products');


});
