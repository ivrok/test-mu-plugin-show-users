<?php

namespace Ivrok\ShowUsers\Cache;

/**
 * Interface CacheInterface
 *
 * This interface provides a set of methods to set and retrieve cache data.
 */
interface CacheInterface
{
    /**
     * Store the data in cache
     *
     * @param string $name         The name of the cache
     * @param mixed $data          The data to store in cache
     * @param int $expireTime      The time in seconds for the cache to expire
     *
     * @return void
     */
    public function setCache(string $name, mixed $data, int $expireTime): void;

    /**
     * Retrieve data from cache
     *
     * @param string $name         The name of the cache
     *
     * @return mixed
     */
    public function getCache(string $name): mixed;
}
