<?php

namespace Ivrok\ShowUsers\Cache;

class CacheFabric
{
    public static function getCacheClass($type)
    {
        switch ($type) {
            case "File":
                return FileCache::getInstance();

            case "Memcached":
                return MemcachedCache::getInstance();
        }
    }
}
