<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Dami\Cli\Command\StatusCommand as DamiStatusCommand;
use Czogori\DamiBundle\Helper\PreparationMigrationDirectory;

class StatusCommand extends AbstractCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:status')
            ->setDescription('Migrations status.');                   
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	
        $this->prepareMigrationDirectory();
        
        $damiStatusCommand = new DamiStatusCommand($this->getName(), $this->getContainer());
        $damiStatusCommand->setApplication($this->getApplication());
        $damiStatusCommand->execute($input, $output);
    }
}
