<?php

namespace Ivrok\ShowUsers\Cache;

class CacheFabric
{
    public static function getCacheClass($type)
    {
        return match ($type) {
            "File"      => FileCache::getInstance(),
            "Memcached" => MemcachedCache::getInstance()
        };
    }
}
