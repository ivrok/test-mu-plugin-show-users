<?php

namespace Ivrok\ShowUsers\Installer;

interface ConfigInterface
{
    public function checkConfig(): bool;

    public function installConfig(): void;
}