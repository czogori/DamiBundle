<?php

namespace Czogori\DamiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ContainerPass implements CompilerPassInterface
{
    /**
     * Processes container.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('dami.migration');
        $definition->addArgument(new Reference('service_container'));
        $definition->setClass('Czogori\DamiBundle\Migration\MigrationContainerAware');
        $container->setDefinition('dami.migration', $definition);
    }
}
