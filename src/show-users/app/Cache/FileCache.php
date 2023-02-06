<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\File\FileNotWritableException;
use Ivrok\ShowUsers\Exceptions\NoSettingsException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;

class FileCache extends AbstractCache
{
    private $cacheDir = null;

    protected function __construct()
    {
        parent::__construct();

        $settings = ServiceContainer::getInstance()->load("su/settings")->getOption('file_cache');

        if (!$settings) {
            throw new NoSettingsException(sprintf("The setting %s is not set", "file_cache"));
        }

        $cacheDir = $settings['cache_dir'];

        if (!$cacheDir) {
            throw new NoSettingsException(sprintf("The setting %s is not set", "cache_dir"));
        }

        if (!is_readable($cacheDir)) {
            throw new FileNotReadableException(sprintf("The directory %s is not readable", $cacheDir));
        }

        if (!is_writable($cacheDir)) {
            throw new FileNotWritableException(sprintf("The directory %s is not writable.", $cacheDir));
        }

        $this->cacheDir = $cacheDir;
    }

    protected function _setCache($name, $data): void
    {
        @file_put_contents($this->getCacheFilename($name), $data);
    }

    protected function _getCache($name): string
    {
        if (!file_exists($this->getCacheFilename($name))) {
            throw new CacheNotExisted("Cache is not existed");
        }

        return @file_get_contents($this->getCacheFilename($name));
    }

    public function removeCache($name): void
    {
        unlink($this->getCacheFilename($name));
    }

    private function getCacheFilename($name): string
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . $name . ".cache";
    }
}
