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
        foreach ($kernel->getBundles() as $bundle) {
            if ($bundle->getName() === $bundleName) {
                echo $bundle->getName();

                $bundleMigrationDirectory = $bundle->getPath() . '/Resources/migrations';
                if (file_exists($bundleMigrationDirectory)) {
                    $filenameBuilder = new FileNameBuilder($migrationName);
                    $fileName = $filenameBuilder->build();

                    $templateRenderer = $this->getContainer()->get('template_renderer');
                    $path = $bundleMigrationDirectory . '/' . $fileName;

                    $fileSystem = new Filesystem();
                    $fileSystem->dumpFile($path, $templateRenderer->render($migrationName));
                }
                break;
            }
        }
    }
}
