<?php

namespace Tests\Users;

use Ivrok\ShowUsers\Cache\CacheInterface;
use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\Http\Users\UsersService;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;
use Ivrok\ShowUsers\Utils\API;
use Mockery;
use Tests\Abstracts\AbstractBase;

class UsersServiceTest extends AbstractBase
{
    private $cache;
    private $settings;
    private $api;
    private $usersService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cache = Mockery::mock(CacheInterface::class);
        $this->api = Mockery::mock(API::class);

        $this->settings = new Settings();
        $this->settings->load(["api_users_domain" => "API", "cache_expiration_time" => 1]);

        ServiceContainer::getInstance()->register('su/cache', $this->cache);
        ServiceContainer::getInstance()->register('su/settings', $this->settings);
        ServiceContainer::getInstance()->register('su/api', $this->api);

        $this->usersService = new UsersService();
    }

    public function testGetAllUsersFromCache()
    {
        $expected = '[{"id":1,"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz"}]';

        $this->cache->shouldReceive('getCache')
            ->andReturn($expected);
        $this->cache->shouldNotReceive('setCache');

        $this->api->shouldNotReceive('request');

        $result = $this->usersService->getAllUsers();
        $this->assertIsArray($result);
        $this->assertEquals(json_decode($expected, true), $result);
    }

    public function testGetAllUsersFromAPI()
    {
        $expected = '[{"id":1,"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz"}]';

        $this->cache->shouldReceive('getCache')->andThrowExceptions([new CacheNotExisted]);
        $this->cache->shouldReceive('setCache');

        $this->api->shouldReceive('request')->andReturn($expected);

        $result = $this->usersService->getAllUsers();
        $this->assertIsArray($result);
        $this->assertEquals(json_decode($expected, true), $result);
    }
    public function testGetUser()
    {
        $expected = '{"id":1,"name":"Leanne Graham","username":"Bret","email":"Sincere@april.biz"}';

        $this->api->shouldReceive('request')->andReturn($expected);

        $result = $this->usersService->getUser(1);

        $this->assertIsArray($result);

        $this->assertEquals(json_decode($expected, true), $result);
    }
}
