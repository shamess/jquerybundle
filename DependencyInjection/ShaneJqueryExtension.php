<?php

namespace Shane\JqueryBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shane\JqueryBundle\DependencyInjection\Configuration;

class ShaneJqueryExtension extends Extension
{
    const PARAMETER_VERSION = 'jquery.version';

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_VERSION, $config['version']);
    }
}
