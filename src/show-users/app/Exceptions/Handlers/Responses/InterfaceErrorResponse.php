<?php
namespace Ivrok\ShowUsers\Exceptions\Handlers\Responses;

interface InterfaceErrorResponse
{
    public function responseException(\Exception $exception): void;
}
