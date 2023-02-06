<?php

namespace Ivrok\ShowUsers\Cache;

interface CacheInterface
{
    public function setCache(string $name, mixed $data, int $expireTime): void;

    public function getCache(string $name): mixed;
}
