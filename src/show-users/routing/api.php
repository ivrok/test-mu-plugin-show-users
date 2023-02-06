<?php

use Ivrok\ShowUsers\Http\Users\UsersAPIController;
use Ivrok\ShowUsers\Http\Users\UsersService;
use Ivrok\WPAPIRouter\HTTPMethodsInterface;
use Ivrok\WPAPIRouter\WPAPIRoute;
use Ivrok\WPAPIRouter\WPAPIRouter;


$usersAPIController = new UsersAPIController(new UsersService());

$apiRouter = new WPApiRouter();
$apiRouter->addRoute(
    new WPApiRoute(
        HTTPMethodsInterface::METHODS["GET"],
        "show-users/v1",
        "/getAll",
        [$usersAPIController, "getAll"]
    )
);
$apiRouter->addRoute(
    new WPApiRoute(
        HTTPMethodsInterface::METHODS["GET"],
        "show-users/v1",
        "/get/(?P<id>\d+)",
        [$usersAPIController, "getUser"]
    )
);
$apiRouter->init();
