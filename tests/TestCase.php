<?php

namespace Reefki\DeviceDetector\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Reefki\DeviceDetector\DeviceDetectorServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            DeviceDetectorServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('cache.default', 'array');
    }
}
