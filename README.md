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

$device = Device::detect($request->userAgent());
```

Detect device from a user agent string and optional hints:

```php
use Reefki\DeviceDetector\Device;

$device = Device::detect($request->userAgent(), $request->server());
```

Detect device from a request instance:

```php
use Reefki\DeviceDetector\Device;

$device = Device::detectRequest($request);
```

Detect device directly from a request instance:

```php
$device = $request->device();
```

All of the above methods wil return a `DeviceDetector\DeviceDetector` instance which you can use to get the information about the device:

```php
if ($device->isBot()) {
    $botInfo = $device->getBot();
} else {
    $clientInfo = $device->getClient();
    $osInfo = $device->getOs();
    $device = $device->getDeviceName();
    $brand = $device->getBrandName();
    $model = $device->getModel();
}
```

Read the [Matomo's Universal Device Detection](https://github.com/matomo-org/device-detector/blob/master/README.md) library readme for more information on how to use the returned instance.

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
