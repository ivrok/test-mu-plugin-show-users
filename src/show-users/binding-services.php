<?php

use Ivrok\ShowUsers\Cache\CacheFabric;
use Ivrok\ShowUsers\Http\Response\Response;
use Ivrok\ShowUsers\Layout\Layout;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;
use Ivrok\ShowUsers\Utils\API;

$sContainer = ServiceContainer::getInstance();

$settings = new Settings();
$settings->loadFile(SU_MAIN_CONFIG);
$sContainer->register("su/settings", $settings);

$layout = new Layout();
$sContainer->register("su/layout", $layout);

$sContainer->register("su/response", new Response($layout));

$cache = CacheFabric::getCacheClass(ServiceContainer::getInstance()->load("su/settings")->getOption("cache_type"));
$sContainer->register("su/cache", $cache);

$sContainer->register("su/api", new API);
