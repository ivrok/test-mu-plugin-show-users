<?php

namespace Ivrok\ShowUsers\Exceptions\Handlers\Responses;

use Ivrok\ShowUsers\Exceptions\IncorrectRequestTypeException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

class ErrorResponseFactory
{
    public static function makeResponse($requestType): InterfaceErrorResponse
    {
        switch ($requestType) {
            case "WEB":
                $response = new WEBErrorResponse(ServiceContainer::getInstance()->load("su/layout"));
                break;
            case "API":
                $response = new APIErrorResponse();
                break;
            default:
                throw new IncorrectRequestTypeException(
                    sprintf("Provided incorrect type of exception - %s. It can be next types: WEB, API.", $requestType)
                );
        }

        return $response;
    }
}
