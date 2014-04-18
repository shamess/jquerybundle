<?php

namespace Shane\JqueryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    const DEFAULT_VERSION = "2.1.0";

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('jquery_management')
            ->children()
                ->scalarNode('version')->defaultValue(self::DEFAULT_VERSION)->end()
            ->end();

        return $builder;
    }
}
