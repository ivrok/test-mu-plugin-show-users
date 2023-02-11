<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\Exceptions\NoConnectionMemcached;
use Ivrok\ShowUsers\Exceptions\NoSettingsException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

/**
 * Class FileCache
 */
class MemcachedCache extends AbstractCache
{
    private $memcached = null;

    /**
     * MemcachedCache constructor.
     *
     * @throws NoSettingsException If the 'memcached' setting is not set.
     * @throws NoConnectionMemcached If there's a problem connecting to the Memcached server.
     */
    public function __construct()
    {
        $settings = ServiceContainer::getInstance()->load("su/settings")->getOption('memcached');

        if (!$settings) {
            throw new NoSettingsException(sprintf("The setting %s is not set", "memcached"));
        }

        $this->memcached = new \Memcached();

        if (!$this->memcached->addServer($settings['server'], $settings['port'])) {
            throw new NoConnectionMemcached(sprintf("Cannot connect with the server %s:%s", $settings['host'], $settings['port']));
        }
    }

    /**
     * Store data in the cache using a given key and expire time.
     *
     * @param string $name The cache key.
     * @param mixed $data The data to be stored in the cache.
     * @param int $expireTime The number of seconds until the cache expires.
     *
     * @throws CacheNotExisted If the cache is not found.
     */
    public function setCache(string $name, mixed $data, int $expireTime): void
    {
        $this->memcached->set($name, $this->prepareDataForCaching($name, $data, $expireTime));
    }
    /**
     * Retrieve cache data by its key.
     *
     * @param string $name The cache key.
     *
     * @return string The cache data.
     *
     * @throws CacheNotExisted If the cache is not found.
     */
    protected function retrieveCacheData($name): string
    {
        $res = $this->memcached->get($name);

        if ($res === false) {
            throw new CacheNotExisted("Cache is not existed");
        }

        return $res;
    }
    /**
     * Remove the cache data with the specified name.
     *
     * @param string $name The name of the cache data to be removed.
     *
     * @throws CacheNotExisted If the cache with the specified name does not exist.
     */
    public function removeCache($name): void
    {
        if (!$this->memcached->delete($name)) {
            throw new CacheNotExisted("Cache with name '{$name}' does not exist");
        }
    }
}
