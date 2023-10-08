<?php

namespace Reefki\DeviceDetector;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DeviceDetectorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->when(CacheRepository::class)
            ->needs(Repository::class)
            ->give(fn ($app) => $app->cache->store(
                $app->config->get('device-detector.cache_store')
            ));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/device-detector.php', 'device-detector');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/device-detector.php' => config_path('device-detector.php'),
            ], 'config');
        }

        $this->app->singleton(DeviceDetector::class, DeviceDetector::class);

        Request::macro('device', function () {
            /** @var \Illuminate\Http\Request $this */
            /** @phpstan-ignore-next-line */
            return app(DeviceDetector::class)->detectRequest($this);
        });
    }
}
