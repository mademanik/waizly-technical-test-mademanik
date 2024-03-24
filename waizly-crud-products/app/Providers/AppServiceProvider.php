<?php

namespace App\Providers;

use App\Http\Services\AuthService;
use App\Http\Services\AuthServiceImpl;
use App\Http\Services\ProductService;
use App\Http\Services\ProductServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductService::class, ProductServiceImpl::class);
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
