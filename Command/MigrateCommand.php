<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Dami\Cli\Command\MigrateCommand as DamiMigrateCommand;
use Dami\Migration;

class MigrateCommand extends ContainerAwareCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:migrate')  
            ->setDescription('Migrate database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	          
        $migration = new Migration($this->getContainer());
    	$damiStatusCommand = new DamiMigrateCommand($this->getName(), $migration);
    	$damiStatusCommand->execute($input, $output);
    }
}
