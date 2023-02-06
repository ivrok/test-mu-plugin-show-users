<?php

namespace Ivrok\ShowUsers\Http\Users\Interfaces;

interface UsersViewInterface
{
    public function show($layout, $params = []): void;
}
