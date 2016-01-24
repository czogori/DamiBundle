<?php

namespace Czogori\DamiBundle\Migration;

use Dami\Migration\Api\MigrationApi;
use Rentgen\Schema\Manipulation;
use Rentgen\Schema\Info;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class MigrationApiContainerAware extends MigrationApi
{
    private $container;

    /**
     * Constructor.
     *
     * @param Manipulation      $manipulation Manipulation instance.
     * @param Info              $info         Info instance.
     * @param ContainerInterfce $container    Container instance.
     */
    public function __construct(Manipulation $manipulation, Info $info, ContainerInterface $container)
    {
        parent::__construct($manipulation, $info);
        $this->container = $container;
    }

    /**
     * Get a container.
     *
     * @return ContainerInterfce|ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

}
