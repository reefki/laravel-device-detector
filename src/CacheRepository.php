<?php

namespace Reefki\DeviceDetector;

use DeviceDetector\Cache\CacheInterface;
use Illuminate\Cache\Repository;

class CacheRepository implements CacheInterface
{
    /**
     * The default cache key prefix for device detector entries.
     *
     * @var string
     */
    public const DEFAULT_PREFIX = 'device-detector:';

    /**
     * The cache repository instance.
     *
     * @var \Illuminate\Cache\Repository
     */
    protected Repository $cache;

    /**
     * The cache key prefix.
     *
     * @var string
     */
    protected string $prefix;

    /**
     * The list of cached keys.
     *
     * @var array<int, string>
     */
    protected array $keys = [];

    /**
     * Create a new cache repository instance.
     *
     * @param  \Illuminate\Cache\Repository  $cache
     * @param  string  $prefix
     * @return void
     */
    public function __construct(Repository $cache, string $prefix = self::DEFAULT_PREFIX)
    {
        $this->cache = $cache;
        $this->prefix = $prefix;

        /** @var array<int, string> $keys */
        $keys = $this->cache->get($this->getKeysKey(), []);
        $this->keys = $keys;
    }

    /**
     * Get the prefixed cache key.
     *
     * @param  string  $id
     * @return string
     */
    protected function key(string $id): string
    {
        return $this->prefix.$id;
    }

    /**
     * Get the key used to store the list of cached keys.
     *
     * @return string
     */
    protected function getKeysKey(): string
    {
        return $this->prefix.'keys';
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Track a cache key.
     *
     * @param  string  $id
     * @return void
     */
    protected function trackKey(string $id): void
    {
        if (! in_array($id, $this->keys, true)) {
            $this->keys[] = $id;
            $this->cache->forever($this->getKeysKey(), $this->keys);
        }
    }

    /**
     * Untrack a cache key.
     *
     * @param  string  $id
     * @return void
     */
    protected function untrackKey(string $id): void
    {
        $this->keys = array_values(array_filter($this->keys, fn ($key) => $key !== $id));
        $this->cache->forever($this->getKeysKey(), $this->keys);
    }

    /**
     * Retrieve an item from the cache by id.
     *
     * @param  string  $id
     * @return mixed
     */
    public function fetch(string $id): mixed
    {
        return $this->cache->get($this->key($id));
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $id
     * @return bool
     */
    public function contains(string $id): bool
    {
        return $this->cache->has($this->key($id));
    }

    /**
     * Store an item in the cache.
     *
     * @param  string  $id
     * @param  mixed  $data
     * @param  int  $lifeTime
     * @return bool
     */
    public function save(string $id, mixed $data, int $lifeTime = 3600): bool
    {
        $this->trackKey($id);

        return $this->cache->put($this->key($id), $data, $lifeTime);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->untrackKey($id);

        return $this->cache->forget($this->key($id));
    }

    /**
     * Remove all device detector items from the cache.
     *
     * @return bool
     */
    public function flushAll(): bool
    {
        foreach ($this->keys as $id) {
            $this->cache->forget($this->key($id));
        }

        $this->keys = [];
        $this->cache->forget($this->getKeysKey());

        return true;
    }
}
