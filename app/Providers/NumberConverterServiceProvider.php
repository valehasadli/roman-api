<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Converter\ArabicNumberConverter;
use App\Services\Converter\Registry\NumberConverterTypeRegistry;
use App\Services\Converter\RomanNumberConverter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

/**
 * Class NumberConverterServiceProvider
 * @package App\Providers
 */
class NumberConverterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(NumberConverterTypeRegistry::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->app->make(NumberConverterTypeRegistry::class)
            ->register(config('convert_number.type.arabic'), new ArabicNumberConverter());

        $this->app->make(NumberConverterTypeRegistry::class)
            ->register(config('convert_number.type.roman'), new RomanNumberConverter());
    }
}
