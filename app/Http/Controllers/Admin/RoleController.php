<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
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
    public function getPermissionsFromRoleId($roleId)
    {
        $arr_role = explode(',', $roleId);
        $roles = Role::whereIn('id', $arr_role)->with('permissions')->get();
        if ($roles) {
            return response()->json([
                'permissions' => $roles->pluck('permissions')->flatten(),
                'message' => 'Permissions retrieved successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }
    }
}
