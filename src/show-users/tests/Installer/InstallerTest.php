<?php

namespace Tests\Installer;

use Ivrok\ShowUsers\Exceptions\PHP\PHPVersionException;
use Ivrok\ShowUsers\Installer\ConfigInterface;
use Ivrok\ShowUsers\Installer\Installer;
use Mockery;
use Tests\Abstracts\AbstractBase;


class InstallerTest extends AbstractBase
{
    private $configMock;
    private $PHPVersion;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configMock = Mockery::mock(ConfigInterface::class);
        $this->PHPVersion = Installer::PHP_VERSION_MIN;
    }

    public function testCheckRequirementsPHPVersionFail()
    {
        $this->expectException(PHPVersionException::class);

        $this->configMock
            ->shouldReceive('checkConfig')
            ->andReturn(true);

        $installer = new Installer($this->configMock, "5.0.0");
        $installer->checkRequirements();
    }

    public function testCheckRequirementsConfigFail()
    {
        $this->configMock
            ->shouldReceive('checkConfig')
            ->andReturnFalse();

        $installer = new Installer($this->configMock, $this->PHPVersion);
        $this->assertFalse($installer->checkRequirements());
    }

    public function testCheckRequirementsSuccess()
    {
        $installer = new Installer($this->configMock, $this->PHPVersion);

        $this->configMock
            ->shouldReceive('checkConfig')
            ->andReturnTrue();

        $this->assertTrue($installer->checkRequirements());
    }

    public function testInstallShouldCallConfigCheckAndCallInstallConfig()
    {
        $installer = new Installer($this->configMock, $this->PHPVersion);

        $this->configMock
            ->shouldReceive('checkConfig')
            ->once()
            ->andReturnFalse();
        $this->configMock
            ->shouldReceive('installConfig')
            ->once();

        $installer->install();
    }
}
