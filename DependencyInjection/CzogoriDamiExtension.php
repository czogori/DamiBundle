<?php

namespace Czogori\DamiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
	{		
 		$configs = $container->getExtensionConfig('propel'); 		
 		if(isset($configs[0]['dbal'])) {
 			$dbal = $configs[0]['dbal'];

	 		$config['adapter'] = $dbal['driver'];
	 		$config['username'] = $dbal['user'];
	 		$config['password'] = $dbal['password'];
	 		$config['dsn'] = $dbal['dsn'];
	        $container->prependExtensionConfig('rentgen', $config);
	    }
	}
}
