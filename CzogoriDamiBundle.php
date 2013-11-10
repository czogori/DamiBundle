<?php

namespace Czogori\DamiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Dami\DependencyInjection\DamiExtension;
use Rentgen\DependencyInjection\RentgenExtension;

class CzogoriDamiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $rentgenExtension = new RentgenExtension();
        $container->registerExtension($rentgenExtension);
        $container->loadFromExtension($rentgenExtension->getAlias());

        $damiExtension = new DamiExtension();
        $container->registerExtension($damiExtension);
        $container->loadFromExtension($damiExtension->getAlias());
    }
}
