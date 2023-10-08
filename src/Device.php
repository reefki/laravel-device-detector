<?php

namespace Reefki\DeviceDetector;

use Illuminate\Support\Facades\Facade;

class Device extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return DeviceDetector::class;
    }
}
