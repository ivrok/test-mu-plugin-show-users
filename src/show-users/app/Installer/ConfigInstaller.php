<?php

namespace Ivrok\ShowUsers\Installer;

use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\File\FileNotWritableException;

class ConfigInstaller implements ConfigInterface
{
    private string $configFile;
    private string $configFileSample;

    public function __construct(string $configFile, string $configFileSample)
    {
        $this->configFile = $configFile;
        $this->configFileSample = $configFileSample;
    }

    public function checkConfig(): bool
    {
        if (!file_exists($this->configFile)) {
            return false;
        } elseif (!is_readable($this->configFile)) {
            throw new FileNotReadableException(sprintf("The config %s is not readable.", $this->configFile));
        }

        return true;
    }

    public function installConfig(): void
    {
        if (!copy($this->configFileSample, $this->configFile)) {
            throw new FileNotWritableException(sprintf("Cannot copy the config sample %s into the config %s", $this->configFileSample, $this->configFile));
        }
    }
}
