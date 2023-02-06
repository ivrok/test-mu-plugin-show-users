<?php

use Ivrok\ShowUsers\Exceptions\Handlers\Handler;
use Ivrok\ShowUsers\Exceptions\Handlers\Responses\ErrorResponseFactory;
use Ivrok\ShowUsers\Installer\ConfigInstaller;
use Ivrok\ShowUsers\Installer\Installer;


require_once "vendor/autoload.php";

define('SU_VERSION', "1.0.1");
define('SU_BASE_DIR', wp_normalize_path(__DIR__));
define('SU_BASE_REL_DIR', str_replace(wp_normalize_path(ABSPATH), '/', SU_BASE_DIR));
define('SU_MAIN_CONFIG', SU_BASE_DIR . "/config.php");

$config = new ConfigInstaller(SU_MAIN_CONFIG, SU_BASE_DIR . "/config.sample.php");
$installer = new Installer($config, phpversion());
if (!$installer->checkRequirements()) {
    $installer->install();
}

try {
    require_once SU_BASE_DIR . "/binding-services.php";

    require_once wp_normalize_path(SU_BASE_DIR . "/routing/web.php");
    require_once wp_normalize_path(SU_BASE_DIR . "/routing/api.php");

} catch (Throwable $e) {

    $handler = new Handler(new ErrorResponseFactory());
    $handler->handleException($e);
}
