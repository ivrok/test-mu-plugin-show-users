<?php

namespace Ivrok\ShowUsers\Layout;

use Ivrok\ShowUsers\Exceptions\File\FileNotFoundException;
use Ivrok\ShowUsers\Utils\Wordpress;

class Layout implements LayoutInterface
{
    private string $layoutDir;

    public function __construct()
    {
        $this->layoutDir = SU_BASE_DIR . DIRECTORY_SEPARATOR . 'layout';
    }

    public function show($layout, $params = []): void
    {
        $layoutFile = $this->layoutDir . DIRECTORY_SEPARATOR . $layout . '.php';

        if (!is_file($layoutFile)) {
            throw new FileNotFoundException(sprintf("Layout %s isn't existed.", $layoutFile));
        }

        add_action("wp_enqueue_scripts", [$this, 'enqueueAssets']);

        extract($params);

        if (Wordpress::isWordpressInitialized()) {
            get_header();
        }

        require $layoutFile;

        if (Wordpress::isWordpressInitialized()) {
            get_footer();
        }
    }

    public function enqueueAssets(): void
    {
        $assets = SU_BASE_DIR . '/assets';
        $assetsRel = SU_BASE_REL_DIR . '/assets';

        $assetsSettings = require_once $assets . '/index.asset.php';

        wp_enqueue_script("su_app_script", SU_BASE_REL_DIR . '/assets/index.js', $assetsSettings['dependencies'], $assetsSettings['version'], true);
        wp_enqueue_style("su_app_styles", SU_BASE_REL_DIR . '/assets/index.css', [], $assetsSettings['version']);
    }


}
