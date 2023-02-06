<?php

namespace Ivrok\ShowUsers\Exceptions\Handlers\Responses;

use Ivrok\ShowUsers\Utils\Debug;

class APIErrorResponse implements InterfaceErrorResponse
{
    public function responseException(\Throwable $exception): void
    {
        $response = [
            "success" => false,
            "message" => "Server error, try please later."
        ];

        $response["message"] = get_class($exception);
        switch (get_class($exception)) {
            case "Exception": break;
        }

        if (Debug::isItDebugMode()) {
            $response["message"] = $exception->getMessage();
            $response["file"] = $exception->getFile();
            $response["line"] = $exception->getLine();
            $response["trace"] = $exception->getTrace();
        }

        echo json_encode($response);
    }
}
