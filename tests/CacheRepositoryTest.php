<?php

namespace Reefki\DeviceDetector\Tests;

use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Reefki\DeviceDetector\CacheRepository;

class CacheRepositoryTest extends TestCase
{
    #[Test]
    public function it_can_save_and_fetch_item(): void
    {
        $cache = app(CacheRepository::class);

        $cache->save('test-key', 'test-value', 3600);

        $this->assertEquals('test-value', $cache->fetch('test-key'));
    }

    #[Test]
    public function it_can_check_if_item_exists(): void
    {
        $cache = app(CacheRepository::class);

        $this->assertFalse($cache->contains('non-existent-key'));

        $cache->save('existing-key', 'value', 3600);

        $this->assertTrue($cache->contains('existing-key'));
    }

    #[Test]
    public function it_can_delete_item(): void
    {
        $cache = app(CacheRepository::class);

        $cache->save('delete-key', 'value', 3600);
        $this->assertTrue($cache->contains('delete-key'));

        $cache->delete('delete-key');
        $this->assertFalse($cache->contains('delete-key'));
    }

    #[Test]
    public function it_can_flush_all_items(): void
    {
        $cache = app(CacheRepository::class);

        $cache->save('flush-key-1', 'value1', 3600);
        $cache->save('flush-key-2', 'value2', 3600);

        $this->assertTrue($cache->contains('flush-key-1'));
        $this->assertTrue($cache->contains('flush-key-2'));

        $cache->flushAll();

        $this->assertFalse($cache->contains('flush-key-1'));
        $this->assertFalse($cache->contains('flush-key-2'));
    }

    #[Test]
    public function it_returns_null_for_non_existent_key(): void
    {
        $cache = app(CacheRepository::class);

        $this->assertNull($cache->fetch('non-existent-key'));
    }

    #[Test]
    public function it_uses_prefix_for_cache_keys(): void
    {
        $cache = app(CacheRepository::class);

        $cache->save('prefixed-key', 'prefixed-value', 3600);

        // The key should be stored with the prefix in Laravel's cache
        $this->assertTrue(Cache::has($cache->getPrefix().'prefixed-key'));
        $this->assertEquals('prefixed-value', Cache::get($cache->getPrefix().'prefixed-key'));

        // But we should still access it without the prefix through our repository
        $this->assertEquals('prefixed-value', $cache->fetch('prefixed-key'));
    }

    #[Test]
    public function it_only_flushes_device_detector_cache_entries(): void
    {
        $cache = app(CacheRepository::class);

        // Save an item through our cache repository
        $cache->save('device-key', 'device-value', 3600);

        // Save an item directly to Laravel's cache (simulating other app cache)
        Cache::put('other-app-key', 'other-value', 3600);

        $this->assertTrue($cache->contains('device-key'));
        $this->assertTrue(Cache::has('other-app-key'));

        // Flush only device detector cache
        $cache->flushAll();

        // Device detector cache should be cleared
        $this->assertFalse($cache->contains('device-key'));

        // Other app cache should remain intact
        $this->assertTrue(Cache::has('other-app-key'));
    }

    #[Test]
    public function it_uses_configurable_prefix(): void
    {
        $this->app['config']->set('device-detector.cache_prefix', 'custom-prefix:');

        // Clear the singleton to force re-creation with new config
        $this->app->forgetInstance(CacheRepository::class);

        $cache = app(CacheRepository::class);

        $this->assertEquals('custom-prefix:', $cache->getPrefix());

        $cache->save('custom-key', 'custom-value', 3600);

        $this->assertTrue(Cache::has('custom-prefix:custom-key'));
        $this->assertEquals('custom-value', $cache->fetch('custom-key'));
    }

    #[Test]
    public function it_uses_default_prefix_when_not_configured(): void
    {
        $cache = app(CacheRepository::class);

        $this->assertEquals(CacheRepository::DEFAULT_PREFIX, $cache->getPrefix());
    }
}
