<?php

namespace Ivrok\ShowUsers\Utils;

class URL
{
    public static function getUrlString($domain, $path, $query)
    {
        return sprintf('%s%s%s',
            $domain,
            $path,
            ($query ? '?' . http_build_query($query) : ""));
    }
}
