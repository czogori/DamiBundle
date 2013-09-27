<?php

namespace Czogori\DamiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Dami\DamiExtension;
use Rentgen\RentgenExtension;

class CzogoriDamiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        // TODO Move connection config to bundle config file
        $config = array();
        $config['adapter'] = 'pgsql';
        $config['host'] = 'localhost';
        $config['database'] = '';
        $config['username'] = '';
        $config['password'] = '';
        $config['port'] = 5432;

		$rentgenExtension = new RentgenExtension($config);
        $container->registerExtension($rentgenExtension);
        $container->loadFromExtension($rentgenExtension->getAlias());        

        $damiExtension = new DamiExtension();        
        $container->registerExtension($damiExtension);
        $container->loadFromExtension($damiExtension->getAlias());        
    }
}

