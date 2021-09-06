<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $user = \App\Models\User::find(1);
        // \Auth::login($user);
        view()->composer('*', function ($view) {
            $me = \Auth::user();
            $view->with('me',$me);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
