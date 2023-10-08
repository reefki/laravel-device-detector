Laravel Device Detector
===

[![tests](https://github.com/reefki/laravel-device-detector/actions/workflows/tests.yml/badge.svg)](https://github.com/reefki/laravel-device-detector/actions/workflows/tests.yml)

The Laravel wrapper for [Matomo Universal Device Detection](https://github.com/matomo-org/device-detector) library seamlessly integrates device detection capabilities into Laravel applications.

## Installation

This package can be installed through Composer.

```bash
composer require reefki/laravel-device-detector
```

Optionally, you can publish the config file of this package with this command:

```bash
php artisan vendor:publish --provider="Reefki\DeviceDetector\DeviceDetectorServiceProvider" --tag="config"
```

## Usage
Detect device from a user agent string:

```php
use Reefki\DeviceDetector\Device;

Device::detect($request->userAgent());
```

Detect device from a user agent string and optional hints:

```php
use Reefki\DeviceDetector\Device;

Device::detect($request->userAgent(), $request->server());
```

Detect device from a request instance:

```php
use Reefki\DeviceDetector\Device;

Device::detectRequest($request);
```

You can also detect from the request instance directly:

```php
$request->device();
```

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
```

## Credits

- [Matomo Universal Device Detection](https://github.com/matomo-org/device-detector)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
