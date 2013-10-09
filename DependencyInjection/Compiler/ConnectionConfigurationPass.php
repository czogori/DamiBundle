<?php

namespace Czogori\DamiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ConnectionConfigurationPass implements CompilerPassInterface
{
    /**
     * Processes container.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $propelConfiguration = $container->get('propel.configuration');        
        $name = $container->getParameter('propel.dbal.default_connection');
        if (isset($propelConfiguration['datasources'][$name])) {
            $defaultConfig = $propelConfiguration['datasources'][$name];
        } else {
            throw new \InvalidArgumentException(sprintf('Connection named %s doesn\'t exist', $name));
        }            
        if (!isset($defaultConfig['connection']['password'])) {
            $defaultConfig['connection']['password'] = null;
        }        
        $connectionConfigDefinition = $container->getDefinition('connection_config');
        $connectionConfigDefinition->replaceArgument(0, $defaultConfig['connection']);
    }
}