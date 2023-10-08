<?php

namespace Reefki\DeviceDetector;

use DeviceDetector\Cache\CacheInterface;
use Illuminate\Cache\Repository;

class CacheRepository implements CacheInterface
{
    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Cache\Repository  $cache
     * @return void
     */
    public function __construct(
        protected Repository $cache
    ) {
    }

    /**
     * Retrieve an item from the cache by id.
     *
     * @param  string  $id
     * @return mixed
     */
    public function fetch(string $id): mixed
    {
        return $this->cache->get($id);
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $id
     * @return bool
     */
    public function contains(string $id): bool
    {
        return $this->cache->has($id);
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
        return $this->cache->put($id, $data, $lifeTime);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->cache->forget($id);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flushAll(): bool
    {
        return $this->cache->flush();
    }
}
