<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Dami\Cli\Command\CreateCommand as DamiCreateCommand;

class CreateCommand extends ContainerAwareCommand
{
	protected function configure()
    {    	
        $this
            ->setName('dami:create')       
            ->setDescription('Create a new migration.')     
            ->setDefinition(array(
                new InputArgument('migration_name', InputArgument::REQUIRED, 'Migration name'),            
        ));                    
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {    	    	          
    	$damiStatusCommand = new DamiCreateCommand($this->getName(), $this->getContainer());
    	$damiStatusCommand->execute($input, $output);
    }
}
