<?php

namespace App\Providers;

use App\Models\Valodas;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

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
        JsonResource::withoutWrapping();

        view()->composer('*', function ($view) {
            $view->with('allLanguages', Valodas::all());
        });
    }
}
