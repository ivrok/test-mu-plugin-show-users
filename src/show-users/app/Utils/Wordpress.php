<?php

namespace Ivrok\ShowUsers\Utils;

class Wordpress
{
    public static function isWordpressInitialized(): bool
    {
        return function_exists('wp_get_current_user');
    }
}
