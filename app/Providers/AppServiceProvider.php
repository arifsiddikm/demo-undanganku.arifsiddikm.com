<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Register admin middleware alias
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    }
}
