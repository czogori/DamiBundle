<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Dami\Cli\Command\StatusCommand as DamiStatusCommand;

class StatusCommand extends ContainerAwareCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:status')
            ->setDescription('Migrations status.');                   
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	          
    	$damiStatusCommand = new DamiStatusCommand($this->getName(), $this->getContainer());
    	$damiStatusCommand->setApplication($this->getApplication());
        $damiStatusCommand->execute($input, $output);
    }
}
