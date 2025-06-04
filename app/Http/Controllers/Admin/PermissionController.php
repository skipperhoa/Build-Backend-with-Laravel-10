<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
class PermissionController extends Controller
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

    /* get permission không có trong role của user */
    public function getPermissionsNotInRole($roleId)
    {


       $roleIds = explode(',', $roleId);

        // Lấy danh sách role kèm permissions
        $roles = Role::whereIn('id', $roleIds)->with('permissions')->get();

        // Kiểm tra xem có role nào không
        if ($roles->isNotEmpty()) {
            // Lấy danh sách ID của các permission thuộc các role
            $assignedPermissionIds = $roles->pluck('permissions')->flatten()->pluck('id')->toArray();

            // Lấy những permission KHÔNG thuộc các role đó
            $unassignedPermissions = Permission::whereNotIn('id', $assignedPermissionIds)->get();

            return response()->json([
                'permissions' => $unassignedPermissions,
                'message' => 'Permissions retrieved successfully',
            ]);
        }

        return response()->json([
            'message' => 'Roles not found',
        ], 404);

    }
}
