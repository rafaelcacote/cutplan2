<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Compartilhar dados da empresa do usuário logado com todas as views
        view()->composer('*', function ($view) {
            if (auth()->check() && auth()->user()->tenant) {
                $view->with('userTenant', auth()->user()->tenant);
            }
        });
    }
}
