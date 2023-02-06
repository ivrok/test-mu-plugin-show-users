<?php

namespace Ivrok\ShowUsers\Utils;

use Ivrok\ShowUsers\Exceptions\APICallException;

class API
{
    /**
     * @param string $domain
     * @param string $path
     * @param array $params
     * @return string
     * @throws APICallException
     */
    public function request(string $domain, string $path, array $params = [])
    {
        $api = URL::getUrlString($domain, $path, $params);

        $res = @file_get_contents($api);

        if ($res === false) {
            $error = error_get_last();
            throw new APICallException(sprintf('API call %s cause an error "%s".', $api, $error['message']));
        }

        return $res;
    }
}
