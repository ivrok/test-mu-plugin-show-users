<?php

namespace Ivrok\ShowUsers\Layout;

interface LayoutInterface
{
    public function show($layout, $params = []): void;
}