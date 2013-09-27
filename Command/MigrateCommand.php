<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Dami\Cli\Command\MigrateCommand as DamiMigrateCommand;
use Dami\Migration;

class MigrateCommand extends AbstractCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:migrate')  
            ->setDescription('Migrate database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	          
        $this->prepareMigrationDirectory();
        
        $migration = new Migration($this->getContainer());
    	$damiStatusCommand = new DamiMigrateCommand($this->getName(), $migration);
    	$damiStatusCommand->execute($input, $output);
    }
}
