<?php

namespace Ivrok\ShowUsers\Http\Response;

use Ivrok\ShowUsers\Layout\LayoutInterface;

class Response
{
    private LayoutInterface $layout;

    public function __construct(LayoutInterface $layout)
    {
        $this->layout = $layout;
    }

    public function sendResponse($layoutName, $data = [])
    {
        $this->layout->show($layoutName, $data);
    }

    public function sendAPIResponse($data)
    {
        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
    }
}
