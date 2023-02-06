<?php

namespace Ivrok\ShowUsers\Installer;

use Ivrok\ShowUsers\Exceptions\PHP\PHPVersionException;

class Installer
{
    const PHP_VERSION_MIN = '8.0.0';

    private ConfigInterface $config;
    private string $currentPhpVersion;

    public function __construct(ConfigInterface $config, string $currentPhpVersion)
    {
        $this->config = $config;
        $this->currentPhpVersion = $currentPhpVersion;
    }

    public function install(): void
    {
        if (!$this->config->checkConfig()) {
            $this->config->installConfig();
        }
    }

    public function checkRequirements(): bool
    {
        if (version_compare(static::PHP_VERSION_MIN, $this->currentPhpVersion, ">")) {
            throw new PHPVersionException(sprintf("Min PHP version is %s.", static::PHP_VERSION_MIN));
        }

        if ($this->config->checkConfig())
        {
            return true;
        }

        return false;
    }
}
