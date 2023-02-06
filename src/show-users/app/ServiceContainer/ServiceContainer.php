<?php

namespace Ivrok\ShowUsers\ServiceContainer;

use Ivrok\ShowUsers\Exceptions\ServiceNotFoundException;

class ServiceContainer
{
    private static $instance = null;
    private $services = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function register($id, $service): void
    {
        $this->services[$id] = $service;
    }

    public function load($id): object
    {
        if (!isset($this->services[$id])) {
            throw new ServiceNotFoundException(sprintf("Service %s not found", $id));
        }

        return $this->services[$id];
    }
}
