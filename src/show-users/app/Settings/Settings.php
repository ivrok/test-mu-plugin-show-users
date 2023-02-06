<?php

namespace Ivrok\ShowUsers\Settings;

use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\SettingsOptionNotFound;

class Settings
{
    private $settings = null;

    public function load(array $settings): void
    {
        $this->settings = $settings;
    }

    public function loadFile(string $settingsFile): void
    {
        if (!is_readable($settingsFile)) {
            throw new FileNotReadableException(sprintf("The file %s is not readable.", $settingsFile));
        }

        $this->settings = require($settingsFile);
    }

    public function getOption($optionName): mixed
    {
        if (!isset($this->settings[$optionName])) {
            throw new SettingsOptionNotFound(sprintf("The settings option %s has not defined.", $optionName));
        }

        return $this->settings[$optionName];
    }
}
