<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;


use App\Models\User;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        if (Schema::hasTable('permissions')) {
        // Tải tất cả permissions trong DB
            $permissions = \App\Models\Permission::all();

            foreach ($permissions as $permission) {
                Gate::define($permission->name, function (User $user) use ($permission) {
                    // Tùy logic: kiểm tra user có quyền trực tiếp hoặc qua role
                    return $user->hasPermission($permission->name);
                });
            }
        }
    }
}
