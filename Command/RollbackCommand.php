<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface;

use Dami\Cli\Command\RollbackCommand as DamiRollbackCommand;

class RollbackCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dami:rollback')
            ->setDescription('Rollback migrations.')
            ->addArgument('to-version', InputArgument::OPTIONAL, 'Rollback to specific version of migrations');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->prepareMigrationDirectory();

            $migration = $this->getContainer()->get('dami.migration');
            $damiStatusCommand = new DamiRollbackCommand($this->getName(), $migration);
            $damiStatusCommand->execute($input, $output);
        } catch (\Exception $e) {
            $output->writeln(sprintf("<error>%s</error>", $e->getMessage()));
        }
    }
}
