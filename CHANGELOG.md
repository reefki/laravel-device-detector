# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2024-12-10

### Added
- Support for Laravel 12
- Support for PHP 8.4
- Configurable cache key prefix via `cache_prefix` config option (defaults to `device-detector:`)
- Key tracking for selective cache flushing (no longer flushes entire cache store)
- `CacheRepository::getPrefix()` method to retrieve the current cache prefix
- Comprehensive test suite with coverage for device detection, cache repository, and edge cases
- Laravel-style docblocks to all source files
- PHPStan level 9 static analysis
- GitHub Actions matrix testing for PHP 8.1-8.4 and Laravel 10-12
- `defineEnvironment()` method in TestCase for consistent test configuration
- `.gitattributes` for cleaner package distribution

### Changed
- Minimum PHP version is now 8.1 (previously 8.0)
- Replaced `laravel/framework` dependency with specific illuminate components (`illuminate/cache`, `illuminate/http`, `illuminate/support`)
- Updated `orchestra/testbench` to `^8.0|^9.0|^10.0`
- Updated `phpunit/phpunit` to `^10.5|^11.0`
- Moved service registration logic from `boot()` to `register()` method following Laravel conventions
- Updated tests to use PHPUnit 11 attributes instead of annotations
- Updated `phpunit.xml` to modern format with caching support
- `CacheRepository::flushAll()` now only removes device detector cache entries instead of flushing entire cache store

### Removed
- Support for Laravel 9 (requires PHP 8.0 which is EOL)
- Support for PHP 8.0

### Fixed
- Variable overwrite bug in README.md example code
- Removed unused PHPStan ignore directive

### Breaking Changes
- Minimum PHP version raised from 8.0 to 8.1
- Dropped support for Laravel 9
- `CacheRepository` constructor signature changed to accept optional `$prefix` parameter
- Cache keys are now prefixed (existing v1.x cache entries will not be found and will be re-cached)
- `CacheRepository::flushAll()` now only flushes device detector entries instead of the entire cache store

## [1.0.2] - Previous Release

### Added
- Initial support for Laravel 10 and 11
