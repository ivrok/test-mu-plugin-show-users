<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheExpired;
use Ivrok\ShowUsers\Exceptions\CacheNotExisted;

abstract class AbstractCache implements CacheInterface
{
    protected abstract function _setCache($name, $data): void;
    protected abstract function _getCache($name): string;
    public abstract function removeCache($name): void;

    public function setCache(string $name, mixed $data, int $expireTime): void
    {
        $this->_setCache($name, json_encode(["expireTime" => $this->getTime($expireTime),"data" => $data]));
    }

    public function getCache(string $name): mixed
    {
        $json = $this->_getCache($name);

        $data = json_decode($json, true);

        if ($data['expireTime'] < $this->getTime(0)) {

            $this->removeCache($name);

            throw new CacheExpired("Cache has been expired.");
        }

        return $data['data'];
    }

    protected function getTime(int $time): int
    {
        return time() + $time;
    }

}