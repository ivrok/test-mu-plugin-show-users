<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheExpired;

/**
 * Class AbstractCache
 */
abstract class AbstractCache implements CacheInterface
{
    /**
     * Remove cache by name
     *
     * @param string $name
     * @return void
     */
    abstract public  function removeCache($name): void;

    /**
     * Set cache data
     *
     * @param string $name
     * @param mixed $data
     * @param int $expireTime
     * @return void
     */
    abstract public function setCache(string $name, $data, int $expireTime): void;

    /**
     * Retrieve cache data by name
     *
     * @param string $name
     * @return string
     */
    abstract protected function retrieveCacheData(string $name): string;

    /**
     * Prepare data for caching
     *
     * @param string $name
     * @param mixed $data
     * @param int $expireTime
     * @return string
     */
    public function prepareDataForCaching(string $name, $data, int $expireTime): string
    {
        return json_encode(["expireTime" => $this->getTime($expireTime),"data" => $data]);
    }

    /**
     * Get cache data by name
     *
     * @param string $name
     * @return mixed
     * @throws CacheExpired
     */
    public function getCache(string $name): mixed
    {
        $json = $this->retrieveCacheData($name);

        $data = json_decode($json, true);

        if ($data['expireTime'] < $this->getTime(0)) {

            $this->removeCache($name);

            throw new CacheExpired("Cache has been expired.");
        }

        return $data['data'];
    }

    /**
     * Get time with offset
     *
     * @param int $time
     * @return int
     */
    protected function getTime(int $time): int
    {
        return time() + $time;
    }

}
