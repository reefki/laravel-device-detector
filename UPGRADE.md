# Upgrade Guide

## Upgrading from 1.x to 2.0

### Requirements

- **PHP**: Minimum version raised from 8.0 to 8.1
- **Laravel**: Dropped support for Laravel 9, added support for Laravel 12

If you're running PHP 8.0 or Laravel 9, you must upgrade before using v2.0.

### Cache Changes

#### Prefixed Cache Keys

Cache keys are now automatically prefixed with `device-detector:` to prevent collisions with other application cache entries. This means:

- Existing cached device detection results from v1.x will **not** be found
- They will simply be re-cached on first access (no errors, just a cache miss)
- No action required unless you were accessing cache keys directly

If you need a custom prefix, you can configure it in `config/device-detector.php`:

```php
'cache_prefix' => env('DEVICE_DETECTOR_CACHE_PREFIX', 'my-custom-prefix:'),
```

#### `flushAll()` Behavior

The `CacheRepository::flushAll()` method now only removes device detector cache entries instead of flushing the entire cache store.

**Before (v1.x):**
```php
// This would flush ALL cache entries in the store
$cacheRepository->flushAll();
```

**After (v2.0):**
```php
// This only flushes device detector entries
$cacheRepository->flushAll();
```

If you relied on the old behavior to flush the entire cache store, use Laravel's cache directly:

```php
use Illuminate\Support\Facades\Cache;

Cache::flush();
```

### CacheRepository Changes

If you were extending or instantiating `CacheRepository` directly, note the constructor signature has changed:

**Before (v1.x):**
```php
public function __construct(Repository $cache)
```

**After (v2.0):**
```php
public function __construct(Repository $cache, string $prefix = self::DEFAULT_PREFIX)
```

The second parameter is optional and defaults to `device-detector:`, so existing code instantiating `CacheRepository` with just the cache repository will continue to work.

### Configuration

A new configuration option has been added. If you've published the config file, you may want to add:

```php
// config/device-detector.php

return [
    'cache_store' => env('DEVICE_DETECTOR_CACHE_STORE'),

    // New in v2.0
    'cache_prefix' => env('DEVICE_DETECTOR_CACHE_PREFIX', 'device-detector:'),
];
```

Or republish the config file:

```bash
php artisan vendor:publish --provider="Reefki\DeviceDetector\DeviceDetectorServiceProvider" --tag="config" --force
```
