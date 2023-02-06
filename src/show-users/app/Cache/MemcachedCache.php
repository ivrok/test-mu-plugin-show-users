<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\Exceptions\NoConnectionMemcached;
use Ivrok\ShowUsers\Exceptions\NoSettingsException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;

class MemcachedCache extends AbstractCache
{
    private $memcached = null;

    protected function __construct()
    {
        parent::__construct();

        $settings = ServiceContainer::getInstance()->load("su/settings")->getOption('memcached');

        if (!$settings) {
            throw new NoSettingsException(sprintf("The setting %s is not set", "memcached"));
        }

        $this->memcached = new \Memcached();

        if (!$this->memcached->addServer($settings['server'], $settings['port'])) {
            throw new NoConnectionMemcached(sprintf("Cannot connect with the server %s:%s", $settings['host'], $settings['port']));
        }
    }

    protected function _setCache($name, $data): void
    {
        $this->memcached->set($name, $data);
    }

    protected function _getCache($name): string
    {
        $res = $this->memcached->get($name);

        if ($res === false) {
            throw new CacheNotExisted("Cache is not existed");
        }

        return $res;
    }

    public function removeCache($name): void
    {}
}
