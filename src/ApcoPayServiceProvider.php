<?php

namespace BornMT\ApcoPay;

use BornMT\ApcoPay\Contracts\ApcoPayServiceInterface;
use BornMT\ApcoPay\Services\ApcoPayService;
use BornMT\ApcoPay\Support\Configuration;
use Illuminate\Support\ServiceProvider;

class ApcoPayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ApcoPayServiceInterface::class, function () {
            return new ApcoPayService(
                new Configuration(
                    config('apcopay.username'),
                    config('apcopay.password'),
                    config('apcopay.pid'),
                    config('apcopay.env') === 'production'
                        ? config('apcopay.base_url')
                        : config('apcopay.sandbox_base_url')
                )
            );
        });
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/apcopay.php',
            'apcopay'
        );

        $this->publishes([
            __DIR__ . '/../config/apcopay.php' => config_path('apcopay.php'),
        ], 'apcopay-config');
    }
}
