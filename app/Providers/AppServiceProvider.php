<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

use App\Models\User;

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
         Gate::define('admin', fn (User $user) => (bool) $user->is_admin);

        //make the cart count global
        View::composer('*', function ($view) {
        $view->with('cartCount', array_sum(session('cart', [])));
    }); 
    }

   
}
