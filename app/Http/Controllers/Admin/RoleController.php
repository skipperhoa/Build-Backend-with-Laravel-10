<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getPermissionsFromRoleId($id)
    {

        if ($id == -1) {
            // No roles selected, return all permissions as not in roles
            return response()->json([
            'permissions' => [],
            'permissions_not_in_roles' => Permission::all(),
            'message' => 'Permissions retrieved successfully',
            ]);
        }

        $roleIds = array_filter(explode(',', $id));
        if (empty($roleIds)) {
            return response()->json([
            'message' => 'Role not found',
            ], 404);
        }

        $roles = Role::whereIn('id', $roleIds)->with('permissions')->get();
        if ($roles->isEmpty()) {
            return response()->json([
            'message' => 'Role not found',
            ], 404);
        }

        $permissions = $roles->pluck('permissions')->flatten()->unique('id')->values();
        $permissionIds = $permissions->pluck('id')->toArray();
        // lấy danh sách permission không thuộc role
        $permissionsNotInRoles = Permission::whereNotIn('id', $permissionIds)->get();

        return response()->json([
            'permissions' => $permissions,
            'permissions_not_in_roles' => $permissionsNotInRoles,
            'message' => 'Permissions retrieved successfully',
        ]);

    }
}
