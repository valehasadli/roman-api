<?php

declare(strict_types=1);

namespace App\Providers;

use App\Mixins\ResponseFactoryMixins;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        ResponseFactory::mixin(new ResponseFactoryMixins());
    }
}
