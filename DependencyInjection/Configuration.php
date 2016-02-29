<?php

namespace RDV\Bundle\MigrationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('rdv_migration');

        $rootNode
            ->children()
                // default path inside each bundle to load migrations
                ->scalarNode('migration_path')
                    ->defaultValue('Migrations/Schema')
                ->end()
                // default path inside each bundle to load fixtures and sample data
                ->scalarNode('fixtures_path')
                    ->defaultValue('Migrations/Data')
                ->end()
                ->arrayNode('namespaces')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $builder;
    }
}
