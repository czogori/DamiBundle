<?php

namespace Czogori\DamiBundle\Tests\Helper;

use Symfony\Component\Filesystem\Filesystem;
use Czogori\DamiBundle\Helper\PreparationMigrationDirectory;

/**
 * @author Arek Jaskólski <arek.jaskolski@gmail.com>
 */
class PreparationMigrationDirectoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bundleDirectory = '/tmp/FooBundle';
        $migrationsDirectoryInBundle = $this->bundleDirectory . '/Resources/migrations';
        $this->migrationFiles = array(
            $migrationsDirectoryInBundle . '/1.php',
            $migrationsDirectoryInBundle . '/2.php',
        );

        $this->fileSystem = new Filesystem();
        $this->fileSystem->mkdir($migrationsDirectoryInBundle);
        $this->fileSystem->touch($this->migrationFiles);
    }

    public function tearDown()
    {
        $this->fileSystem->remove('/tmp/FooBundle');
        $this->fileSystem->remove('/tmp/FooBundleTest');
    }

    public function test_prepare()
    {
        $baseDirectory = '/tmp/FooBundleTest';
        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle
            ->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue($this->bundleDirectory));
        $preparationMigrationDirectory = new PreparationMigrationDirectory($baseDirectory, array($bundle));
        $preparationMigrationDirectory->prepare();

        $this->assertTrue($this->fileSystem->exists($this->migrationFiles[0]));
        $this->assertTrue($this->fileSystem->exists($this->migrationFiles[1]));
    }
}
