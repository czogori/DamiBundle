<?php

namespace Czogori\DamiBundle\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Filesystem\Filesystem;

use Dami\Migration\FileNameBuilder;

class CreateCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('dami:create')
            ->setDescription('Create a new migration.')
            ->setDefinition(array(
                new InputArgument('migration_name', InputArgument::REQUIRED, 'Migration name'),
                new InputArgument('bundle_name', InputArgument::REQUIRED, 'Bundle name'),
        ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArguments();
        $migrationName = $arguments['migration_name'];
        $bundleName = $arguments['bundle_name'];

        $kernel = $this->getContainer()->get('kernel');
        $budleExists = false;
        foreach ($kernel->getBundles() as $bundle) {
            if ($bundle->getName() === $bundleName) {
                $bundleMigrationDirectory = $bundle->getPath() . '/Resources/migrations';
                $fileSystem = new Filesystem();
                if (!file_exists($bundleMigrationDirectory)) {
                    $output->writeln('<error>Directory of migrations does not exist.</error>');

                    $dialog = $this->getHelperSet()->get('dialog');
                    if(!$dialog->askConfirmation(
                        $output,
                        sprintf('<question>Do you want to create %s directory? (Y/n)</question>', $bundleMigrationDirectory),
                        true)) {
                            return;
                    }
                    $fileSystem->mkdir($bundleMigrationDirectory);
                    $output->writeln('<info>Directory of migrations has been created.</info>');
                    $output->writeln(sprintf('<comment>Location: %s</comment>', $bundleMigrationDirectory));
                }
                $filenameBuilder = new FileNameBuilder($migrationName);
                $templateRenderer = $this->getContainer()->get('dami.template_renderer');
                try {
                    $fileName = $filenameBuilder->build();
                    $path = $bundleMigrationDirectory . '/' . $fileName;
                    $fileSystem->dumpFile($path, $templateRenderer->render($migrationName));

                    $output->writeln('<info>Migration has been created.</info>');
                    $output->writeln(sprintf('<comment>Location: %s</comment>', $path));
                } catch (\Exception $e) {
                    $output->writeln(sprintf("<error>Something went wrong.</error>\n\n%s", $e->getMessage()));
                }
                $budleExists = true;
                break;
            }
        }
        if (false === $budleExists) {
            $output->writeln(sprintf('<comment>Bundle %s does not exist.</comment>', $bundleName));
        }
    }
}
