<?php

namespace Ivrok\ShowUsers\Http\Users;

use Ivrok\ShowUsers\Http\Response\Response;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Http\Users\Interfaces\UsersServiceInterface;

class UsersAPIController
{
    private UsersServiceInterface $usersService;
    private Response $response;

    public function __construct(UsersServiceInterface $usersService)
    {
        $this->usersService = $usersService;
        $this->response = ServiceContainer::getInstance()->load("su/response");
    }

    public function getAll()
    {
        $this->response->sendAPIResponse(['users' => $this->usersService->getAllUsers()]);
    }

    public function getUser($request)
    {
        $this->response->sendAPIResponse(['users' => $this->usersService->getUser($request['id'])]);
    }
}
