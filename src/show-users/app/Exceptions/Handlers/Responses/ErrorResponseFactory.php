<?php

namespace Ivrok\ShowUsers\Exceptions\Handlers\Responses;

use Ivrok\ShowUsers\Exceptions\IncorrectRequestTypeException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

class ErrorResponseFactory
{
    public static function makeResponse($requestType): InterfaceErrorResponse
    {
        return match ($requestType) {
            'WEB'   => new WEBErrorResponse(ServiceContainer::getInstance()->load("su/layout")),
            'API'   => new APIErrorResponse(),
            default => throw new IncorrectRequestTypeException(
                sprintf("Provided incorrect type of exception - %s. It can be next types: WEB, API.", $requestType)
            )
        };
    }
}
