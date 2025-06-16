<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
//use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      // Paginator::useBootstrap();
        // log sql, bindings, and execution time
        DB::listen(function ($query) {
            info($query->sql, $query->bindings, $query->time);
        });
    }
}
