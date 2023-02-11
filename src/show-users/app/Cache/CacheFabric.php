<?php

namespace Ivrok\ShowUsers\Cache;

/**
 * Class CacheFabric
 */
class CacheFabric
{
    /**
     * Returns instance of cache object
     *
     * @param string $type Type of the cache
     *
     * @return object Instance of cache object
     */
    public static function getCache($type)
    {
        return match ($type) {
            "File"      => new FileCache(),
            "Memcached" => new MemcachedCache()
        };
    }
}
