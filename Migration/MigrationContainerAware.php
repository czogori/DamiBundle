<?php

namespace Czogori\DamiBundle\Migration;

use Dami\Migration;
use Dami\Migration\MigrationFiles;
use Dami\Migration\SchemaTable;
use Rentgen\Schema\Info;
use Rentgen\Schema\Manipulation;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MigrationContainerAware extends Migration
{
    private $container;

    /**
     * @param SchemaTable        $schemaTable        description
     * @param MigrationFiles     $migrationFiles     description
     * @param Manipulation       $schemaManipulation description
     * @param Info               $schemaInfo         description
     * @param ContainerInterface $container          description
     */
    public function __construct(
        SchemaTable $schemaTable,
        MigrationFiles $migrationFiles,
        Manipulation $schemaManipulation,
        Info $schemaInfo,
        ContainerInterface $container)
    {
        parent::__construct($schemaTable, $migrationFiles, $schemaManipulation, $schemaInfo);
        $this->container = $container;
    }

    /**
     * Create an instance of migration class.
     *
     * @param $className Name of migration class.
     *
     * @return mixed
     */
    protected function createMigrationApiInstance($className)
    {
        return new $className($this->schemaManipulation, $this->schemaInfo, $this->container);
    }
}

