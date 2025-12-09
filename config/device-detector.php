<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the cache store that will be used to cache the
    | device detection results. You may set this to any of the cache stores
    | defined in your cache configuration file. If set to null, the default
    | cache store will be used.
    |
    */

    'cache_store' => env('DEVICE_DETECTOR_CACHE_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    |
    | This option controls the prefix that will be used for all cache keys
    | created by the device detector. This helps isolate device detector
    | cache entries from other application cache entries.
    |
    */

    'cache_prefix' => env('DEVICE_DETECTOR_CACHE_PREFIX', 'device-detector:'),

];
