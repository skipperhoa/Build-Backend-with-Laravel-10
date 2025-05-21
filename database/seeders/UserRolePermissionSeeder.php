<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'nguyen.thanh.hoa.ctec@gmail.com';
        $user = User::where('email', $email)->first();

        $role = Role::where('name', 'Super Admin')->first();

        if ($user && $role) {
            $user->roles()->attach($role);
        }

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $role->permissions()->attach($permission);
        }


    }
}
