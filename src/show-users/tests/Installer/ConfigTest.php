<?php

namespace Tests\Installer;

use Ivrok\ShowUsers\Exceptions\File\FileNotReadableException;
use Ivrok\ShowUsers\Exceptions\File\FileNotWritableException;
use Ivrok\ShowUsers\Installer\ConfigInstaller;
use Tests\Abstracts\AbstractBase;
use Brain\Monkey\Functions;

class ConfigTest extends AbstractBase
{
    private $configFile;
    private $configFileSample;

    protected function setUp(): void
    {
        parent::setUp();

        $tmpDir = sys_get_temp_dir();

        $this->configFile = $tmpDir . '/config.txt';
        $this->configFileSample = $tmpDir . '/config-sample.txt';

        file_put_contents($this->configFileSample, 'sample content');
        file_put_contents($this->configFile, 'config content');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unlink($this->configFile);
        unlink($this->configFileSample);
    }

    private function getConfig()
    {
        return new ConfigInstaller($this->configFile, $this->configFileSample);
    }

    public function testCheckConfigFileReadableSuccess()
    {
        $this->assertTrue($this->getConfig()->checkConfig());
    }

    public function testCheckConfigFileReadableFail()
    {
        Functions\when('is_readable')->justReturn(false);
        $this->expectException(FileNotReadableException::class);
        $this->getConfig()->checkConfig();
    }

    public function testInstallConfigSuccess()
    {
        unlink($this->configFile);

        $this->getConfig()->installConfig();

        $this->assertTrue(file_exists($this->configFile));
    }

    public function testInstallConfigNotWritableFail()
    {
        Functions\when('copy')->justReturn(false);
        $this->expectException(FileNotWritableException::class);
        $this->getConfig()->installConfig();
    }
}
