<?php

namespace Reefki\DeviceDetector;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \DeviceDetector\DeviceDetector detect(string $userAgent, array $headers = [])
 * @method static \DeviceDetector\DeviceDetector detectRequest(\Illuminate\Http\Request $request)
 *
 * @see \Reefki\DeviceDetector\DeviceDetector
 */
class Device extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return DeviceDetector::class;
    }
}
