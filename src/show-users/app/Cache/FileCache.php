<?php

namespace Ivrok\ShowUsers\Cache;

use Ivrok\ShowUsers\Exceptions\CacheNotExisted;
use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\File\FileNotWritableException;
use Ivrok\ShowUsers\Exceptions\NoSettingsException;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;

/**
 * Class FileCache
 */
class FileCache extends AbstractCache
{
    /**
     * Cache directory
     *
     * @var string|null
     */
    private $cacheDir = null;


    /**
     * FileCache constructor.
     *
     * The constructor sets the cache directory path.
     * Throws NoSettingsException if the cache directory path is not set.
     * Throws FileNotReadableException if the cache directory is not readable.
     * Throws FileNotWritableException if the cache directory is not writable.
     *
     * @throws NoSettingsException
     * @throws FileNotReadableException
     * @throws FileNotWritableException
     */
    public function __construct()
    {

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

    /**
    * Set cache for a given data
    * The method writes the data in the cache file.
    *
    * @param string $name Name of cache
    * @param mixed $data Data to cache
    * @param int $expireTime Expire time of cache in seconds
    * @return void
    */
    public function setCache(string $name, mixed $data, int $expireTime): void
    {
        @file_put_contents($this->getCacheFilename($name), $this->prepareDataForCaching($name, $data, $expireTime));
    }

    /**
     * Retrieves the cache data with the given name.
     * Throws CacheNotExisted if the cache file doesn't exist.
     *
     * @param string $name The name of the cache.
     * @throws CacheNotExisted
     * @return string The data stored in the cache.
     */
    protected function retrieveCacheData($name): string
    {
        if (!file_exists($this->getCacheFilename($name))) {
            throw new CacheNotExisted("Cache is not existed");
        }

        return @file_get_contents($this->getCacheFilename($name));
    }

    /**
     * Removes the cache with the given name.
     *
     * @param string $name The name of the cache.
     */
    public function removeCache($name): void
    {
        unlink($this->getCacheFilename($name));
    }

    /**
     * Returns the full path to the cache file with the given name.
     *
     * @param string $name The name of the cache.
     *
     * @return string The full path to the cache file.
     */
    private function getCacheFilename($name): string
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . $name . ".cache";
    }
}
