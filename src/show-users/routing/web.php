<?php

use Ivrok\ShowUsers\Http\Users\UsersController;
use Ivrok\WPRouter\WPRoute;
use Ivrok\WPRouter\WPRouter;


$usersController = new UsersController();

$router = new WPRouter();
$router->addRoute(new WPRoute("show-users", [$usersController, "index"]));
$router->addRoute(new WPRoute("show-users/{su_id}", [$usersController, "index"]));
$router->init();
