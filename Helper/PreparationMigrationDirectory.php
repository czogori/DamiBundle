<?php

namespace Czogori\DamiBundle\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class PreparationMigrationDirectory
{
    private $baseDirectory;
    private $bundles;

    /**
     * Constructor
     *
     * @param string                                                $baseDirectory Base directory for migrations.
     * @param Symfony\Component\HttpKernel\Bundle\BundleInterface[] $bundles       Array of BunleInterface instances.
     */
    public function __construct($baseDirectory, $bundles)
    {
        $this->baseDirectory = $baseDirectory;
        $this->bundles = $bundles;
        $this->fileSystem = new Filesystem();
    }

    /**
     * Prepare migration directory to use.
     *
     * @return void
     */
    public function prepare()
    {
        $migrationDirectory = $this->baseDirectory;
        if ($this->fileSystem->exists($migrationDirectory)) {
            $this->fileSystem->remove(array($migrationDirectory));
        }
        $this->fileSystem->mkdir($migrationDirectory);

        foreach ($this->bundles as $bundle) {
            $bundleMigrationDirectory = $bundle->getPath() . '/Resources/migrations';
            if (file_exists($bundleMigrationDirectory)) {
                $finder = new Finder();
                $finder->files('*.php')->in($bundleMigrationDirectory);
                foreach ($finder as $file) {
                   $this->fileSystem->copy($file->getRealpath(), $migrationDirectory . '/' . $file->getFilename(), true);
                }
            }
        }
    }
}
