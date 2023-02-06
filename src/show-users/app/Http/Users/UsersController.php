<?php

namespace Ivrok\ShowUsers\Http\Users;

use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

class UsersController
{

    public function index()
    {
        ServiceContainer::getInstance()->load("su/response")->sendResponse("index");
    }
}
