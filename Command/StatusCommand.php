<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Dami\Cli\Command\StatusCommand as DamiStatusCommand;

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
        try {
            $this->prepareMigrationDirectory();

            $damiStatusCommand = new DamiStatusCommand($this->getName(), $this->getContainer());
            $damiStatusCommand->setApplication($this->getApplication());
            $damiStatusCommand->execute($input, $output);
        } catch (\Exception $e) {
            $output->writeln(sprintf("<error>%s</error>", $e->getMessage()));
        }
    }
}
