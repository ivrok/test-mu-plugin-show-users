<?php

namespace Tests\Users;

use Ivrok\ShowUsers\Http\Users\UsersController;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Tests\Abstracts\AbstractBase;

class UsersControllerTest extends AbstractBase
{
    public function testIndexMethodCallsShowMethodOnLayout()
    {
        $GLOBALS['assertion'] = false;

        ServiceContainer::getInstance()->register("su/response", new class {
            public function sendResponse() { $GLOBALS['assertion'] = true; }
        });

        $controller = new UsersController();
        $controller->index();

        $this->assertTrue($GLOBALS['assertion']);
    }
}
