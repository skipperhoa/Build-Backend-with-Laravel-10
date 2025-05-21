<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // chúng ta nên đặt tên đúng với router name
        $permissions = [
            "admin.users.create",
            "admin.users.edit",
            "admin.users.index",
            "admin.users.show",
            "admin.users.destroy",
            "admin.users.update",
        ];

        /**
         * Sau này nếu hay hơn chúng ta sẽ dùng getRoutees()
         * sau đó dùng $route->getName() để lấy tên route
         */

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
