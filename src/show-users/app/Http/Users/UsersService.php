<?php

namespace Ivrok\ShowUsers\Http\Users;

use Ivrok\ShowUsers\Cache\CacheInterface;
use Ivrok\ShowUsers\Exceptions\CacheExpired;
use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;
use Ivrok\ShowUsers\Http\Users\Interfaces\UsersServiceInterface;
use Ivrok\ShowUsers\Utils\API;

class UsersService implements UsersServiceInterface
{
    const API_PATHS = [
        "USERS" => "/users",
        "USER_DETAILS" => "/users/%d"
    ];
    private string $apiDomain;

    private CacheInterface $cache;
    private Settings $settings;
    private API $api;

    public function __construct()
    {
        $this->cache = ServiceContainer::getInstance()->load('su/cache');
        $this->settings = ServiceContainer::getInstance()->load('su/settings');
        $this->api = ServiceContainer::getInstance()->load('su/api');

        $this->apiDomain = $this->settings->getOption('api_users_domain');
    }

    public function getAllUsers(): array
    {
        $cacheName = $this->getCacheName("allUsers");

        try {
            $users = $this->cache->getCache($cacheName);
        } catch (CacheNotExisted | CacheExpired $e) {

            $users = $this->api->request($this->apiDomain, static::API_PATHS['USERS']);

            $this->cache->setCache($cacheName, $users, $this->settings->getOption("cache_expiration_time"));
        }

        return $this->toArray($users);
    }

    public function getUser($id): array
    {
        return $this->toArray($this->api->request($this->apiDomain, sprintf(static::API_PATHS['USER_DETAILS'], $id)));
    }

    private function getCacheName(string $name, array $params = []): string
    {
        return preg_replace("/[^\w]+/", "", $this->apiDomain) . "_" .  $name . http_build_query($params);
    }
    private function toArray($res): array
    {
        return json_decode($res, true);
    }
}
