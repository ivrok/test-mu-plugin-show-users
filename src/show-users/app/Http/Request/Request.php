<?php

namespace Ivrok\ShowUsers\Http\Request;

class Request
{
    public static function getRequestType(): string
    {
        $reqType = "WEB";

        if (isset($_SERVER['HTTP_ACCEPT'])
            && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false
        ) {
            $reqType = "API";
        }

        return $reqType;
    }
}
