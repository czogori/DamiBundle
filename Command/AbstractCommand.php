<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Czogori\DamiBundle\Helper\PreparationMigrationDirectory;

abstract class AbstractCommand extends ContainerAwareCommand
{
    protected function prepareMigrationDirectory()
    {
        $kernel = $this->getContainer()->get('kernel');

        $preparationMigrationDirectory = new PreparationMigrationDirectory($kernel->getCacheDir(), $kernel->getBundles());
        $preparationMigrationDirectory->prepare();
    }
}
