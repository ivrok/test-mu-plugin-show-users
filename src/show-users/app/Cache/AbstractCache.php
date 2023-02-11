<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheExpired;

abstract class AbstractCache implements CacheInterface
{
    abstract public  function removeCache($name): void;
    abstract public function setCache(string $name, mixed $data, int $expireTime): void;
    abstract protected function retrieveCacheData(string $name): string;

    public function prepareDataForCaching(string $name, mixed $data, int $expireTime): string
    {
        return json_encode(["expireTime" => $this->getTime($expireTime),"data" => $data]);
    }

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

    protected function getTime(int $time): int
    {
        return time() + $time;
    }

}
