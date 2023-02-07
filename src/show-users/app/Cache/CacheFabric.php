<?php

namespace Ivrok\ShowUsers\Cache;

class CacheFabric
{
    public static function getCache($type)
    {
        return match ($type) {
            "File"      => new FileCache(),
            "Memcached" => new MemcachedCache()
        };
    }
}
