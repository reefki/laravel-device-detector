<?php

namespace Reefki\DeviceDetector;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DeviceDetectorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/device-detector.php', 'device-detector');

        $this->app->singleton(DeviceDetector::class, DeviceDetector::class);

        $this->app->singleton(CacheRepository::class, function ($app) {
            return new CacheRepository(
                $app->cache->store($app->config->get('device-detector.cache_store')),
                $app->config->get('device-detector.cache_prefix', CacheRepository::DEFAULT_PREFIX)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/device-detector.php' => config_path('device-detector.php'),
            ], 'config');
        }

        Request::macro('device', function () {
            /** @var \Illuminate\Http\Request $this */
            return app(DeviceDetector::class)->detectRequest($this);
        });
    }
}
