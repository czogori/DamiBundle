<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Dami\Cli\Command\RollbackCommand as DamiRollbackCommand;
use Dami\Migration;

class RollbackCommand extends ContainerAwareCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:rollback')  
            ->setDescription('Rollback migrations.')
            ->addArgument('to-version', InputArgument::OPTIONAL, 'Rollback to specific version of migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	          
        $migration = new Migration($this->getContainer());
    	$damiStatusCommand = new DamiRollbackCommand($this->getName(), $migration);
    	$damiStatusCommand->execute($input, $output);
    }
}
