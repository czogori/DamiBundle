<?php

namespace Czogori\DamiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CzogoriDamiExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('dami.migrations_directory', $config['migrations_directory']);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('propel');
        foreach ($configs as $config) {
            if (isset($config['dbal'])) {
                $dbal = $config['dbal'];

                $connectionConfig['adapter'] = $dbal['driver'];
                $connectionConfig['username'] = $dbal['user'];
                $connectionConfig['password'] = $dbal['password'];
                $connectionConfig['dsn'] = $dbal['dsn'];
                $container->prependExtensionConfig('rentgen', $connectionConfig);
            }
        }
    }
}
