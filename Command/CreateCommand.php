<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Dami\Cli\Command\CreateCommand as DamiCreateCommand;

class CreateCommand extends AbstractCommand
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
        $this->prepareMigrationDirectory();

        $damiStatusCommand = new DamiCreateCommand($this->getName(), $this->getContainer());
        $damiStatusCommand->execute($input, $output);
    }
}
