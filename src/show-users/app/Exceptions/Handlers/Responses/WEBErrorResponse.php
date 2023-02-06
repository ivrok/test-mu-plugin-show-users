<?php

namespace Ivrok\ShowUsers\Exceptions\Handlers\Responses;

use Ivrok\ShowUsers\Layout\LayoutInterface;
use Ivrok\ShowUsers\Utils\Debug;

class WEBErrorResponse implements InterfaceErrorResponse
{
    private LayoutInterface $layout;

    public function __construct(LayoutInterface $template)
    {
        $this->template = $template;
    }

    public function responseException(\Throwable $exception): void
    {
        $response = "Server error, try please later.";

        if (Debug::isItDebugMode()) {
            $response = sprintf(
                "<h1>There was an error: %s.</h1>
                        \n<br /><h2>File %s:%s.</h2>
                        \n<br /><h2>Trace: </h2>
                        \n<br /><span>%s</span>",
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                array_reduce($exception->getTrace(), function($stack, $stackItem){
                    $stack .= (isset($stackItem['class']) ? $stackItem['class'] . ":" : "") . $stackItem['function'];
                    $stack .= isset($stackItem['file']) ? " > " . $stackItem['file'] . $stackItem['line'] : "";
                    $stack .= "\n<br />";
                    return $stack;
                })
            );
        }

        $this->template->show("error", ['error' => $response]);
    }
}
