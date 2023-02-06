<?php

namespace Ivrok\ShowUsers\Utils;

use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

class Debug
{
    public static function isItDebugMode(): bool
    {
        return ServiceContainer::getInstance()->load("su/settings")->getOption("debug");
    }
}
