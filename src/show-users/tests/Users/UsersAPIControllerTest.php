<?php

namespace Tests\Users;

use Ivrok\ShowUsers\Http\Response\Response;
use Ivrok\ShowUsers\Http\Users\Interfaces\UsersServiceInterface;
use Ivrok\ShowUsers\Http\Users\UsersAPIController;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Mockery;
use Tests\Abstracts\AbstractBase;

class UsersAPIControllerTest extends AbstractBase
{
    private $usersService;

    public function setUp(): void
    {
        parent::setUp();

        $this->usersService = Mockery::mock(UsersServiceInterface::class);

        $response = Mockery::mock(Response::class);
        $response->shouldReceive("sendAPIResponse")->once();
        ServiceContainer::getInstance()->register("su/response", $response);
    }

    public function testGetAllSuccess()
    {
        $this->usersService->shouldReceive('getAllUsers')->once()->andReturn([]);

        $controller = new UsersAPIController($this->usersService);
        $controller->getAll();

        $this->assertTrue(true);
    }

    public function testGetUserSuccess()
    {
        $this->usersService->shouldReceive('getUser')->once()->andReturn([]);

        $controller = new UsersAPIController($this->usersService);
        $controller->getUser(['id' => 1]);

        $this->assertTrue(true);
    }
}
