<?php

namespace Czogori\DamiBundle\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class PreparationMigrationDirectory
{
	private $baseDirectory;
	private $bundles;

	public function __construct($baseDirectory, $bundles)
	{
		$this->baseDirectory = $baseDirectory;
		$this->bundles = $bundles;
		$this->fileSystem = new Filesystem();
	}

	public function prepare()
	{
		$migrationDirectory = $this->getDirectory();
		$this->createDirectory($migrationDirectory);
 
        foreach ($this->bundles as $bundle) {
            $bundleMigrationDirectory = $bundle->getPath() . '/Resources/migrations';
            if(file_exists($bundleMigrationDirectory)) {
                $finder = new Finder();
                $finder->files('*.php')->in($bundleMigrationDirectory);
                foreach ($finder as $file) {     
                   $this->fileSystem->copy($file->getRealpath(), $migrationDirectory . $file->getFilename(), true);
                }     
            }
        }        
	}

	private function createDirectory($migrationDirectory)
	{
        try {            
            $this->fileSystem->mkdir($migrationDirectory);
        } catch (IOException $e) {
            echo 'Nie można utworzyć katalogu ' . $migrationDirectory;
        }
	}

	private function getDirectory()
	{
		return $this->baseDirectory . '/migrations/';
	}
}