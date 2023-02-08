<?php

namespace Ivrok\ShowUsers\Exceptions\Handlers;


use Ivrok\ShowUsers\Exceptions\Handlers\Responses\ErrorResponseFactory;
use Ivrok\ShowUsers\Http\Request\Request;

class Handler
{
    private $responseFactory;

    public function __construct(ErrorResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handleException($exception): void
    {
        status_header(500);

        do_action("critical_error", $exception);

        $response = $this->responseFactory->makeResponse(Request::getRequestType());

        $response->responseException($exception);

        wp_die($exception->getMessage());
    }
}
