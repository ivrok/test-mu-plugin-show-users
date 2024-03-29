<?php

namespace Tests\Cache;

use Ivrok\ShowUsers\Cache\FileCache;
use Ivrok\ShowUsers\Exceptions\CacheExpired;
use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\File\FileNotWritableException;
use Ivrok\ShowUsers\Exceptions\NoSettingsException;
use Ivrok\ShowUsers\Exceptions\SettingsOptionNotFound;
use Ivrok\ShowUsers\ServiceContainer\ServiceContainer;
use Ivrok\ShowUsers\Settings\Settings;
use Mockery;
use Tests\Abstracts\AbstractBase;
use Brain\Monkey\Functions;

class FileCacheTest extends AbstractBase
{
    private string $cacheDir;
    private string $cacheTestName = "test_cache";

    protected function setUp(): void
    {
        parent::setUp();

        $this->cacheDir = sys_get_temp_dir();

        $this->settings = new Settings();

        ServiceContainer::getInstance()->register("su/settings", $this->settings);

        $this->loadSettings();
    }

    private function loadSettings()
    {
        $this->settings->load([
            "cache_expiration_time" => 60 * 60 * 24, //24 hours
            "file_cache" => [
                "cache_dir" => $this->cacheDir,
            ]
        ]);
    }

    private function getCacheFilePath($cacheName)
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . $cacheName . ".cache";
    }

    public function testConstructorExceptionSettingsOptionNotFound()
    {
        $this->settings->load([]);

        $this->expectException(SettingsOptionNotFound::class);

        new FileCache();
    }

    public function testConstructorExceptionCacheDirNotReadable()
    {
        Functions\when('is_readable')->justReturn(false);

        $this->expectException(FileNotReadableException::class);

        new FileCache();
    }

    public function testConstructorExceptionCacheDirNotWritable()
    {
        $this->loadSettings();

        Functions\when('is_writable')->justReturn(false);

        $this->expectException(FileNotWritableException::class);

        new FileCache();
    }

    public function testSetCacheSuccess()
    {
        $cacheName = $this->cacheTestName;
        $cacheFile = $this->getCacheFilePath($cacheName);
        $cacheContent = "test_data";
        $expiredTime = -1;
        $expected = sprintf('{"expireTime":%d,"data":"%s"}', time() - 1, $cacheContent);

        $cache = new FileCache();
        $cache->setCache($cacheName, $cacheContent, $expiredTime);

        $this->assertFileExists($cacheFile);
        $this->assertStringEqualsFile($cacheFile, $expected);
    }

    public function testExceptionCacheExpiredFail()
    {
        $cacheName = "test_cache";

        $this->expectException(CacheExpired::class);

        $cache = new FileCache();
        $cache->getCache($cacheName);
    }

    public function testGetCache()
    {
        $cacheName = $this->cacheTestName;
        $cacheFile = $this->getCacheFilePath($cacheName);
        $expectedCacheContent = "expected cache";

        @file_put_contents($cacheFile, sprintf('{"expireTime":%d,"data":"%s"}', time(), $expectedCacheContent));


        $cache = new FileCache();
        $data = $cache->getCache($this->cacheTestName);

        $this->assertEquals($expectedCacheContent, $data);
    }

    public function testRemoveCache()
    {
        $cacheName = $this->cacheTestName;
        $cacheFile = $this->getCacheFilePath($cacheName);
        $expectedCacheContent = "expected cache";

        @file_put_contents($cacheFile, sprintf('{"expireTime":%d,"data":"%s"}', time(), $expectedCacheContent));

        $cache = new FileCache();
        $cache->removeCache($this->cacheTestName);

        $this->assertTrue(!file_exists($cacheFile));
    }
}
