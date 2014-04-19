<?php

namespace Shane\JqueryBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Shane\JqueryBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;

class ShaneJqueryExtension extends Extension
{
    const PARAMETER_VERSION = 'jquery.version';
    const PARAMETER_DIRECTORY = 'jquery.write_directory';

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_VERSION, $config['version']);
        $container->setParameter(self::PARAMETER_DIRECTORY, __DIR__ . '/../Resources/public/js/');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
