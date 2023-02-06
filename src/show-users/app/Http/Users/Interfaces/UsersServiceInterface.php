<?php

namespace Ivrok\ShowUsers\Http\Users\Interfaces;

interface UsersServiceInterface
{
    public function getAllUsers(): array;
    public function getUser($id): array;
}
