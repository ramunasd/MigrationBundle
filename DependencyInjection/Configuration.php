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
                ->scalarNode('fixtures_path_main')
                    ->defaultValue('Migrations/Data/ORM')
                ->end()
                ->scalarNode('fixtures_path_demo')
                    ->defaultValue('Migrations/Data/Demo/ORM')
                ->end()
            ->end();

        return $builder;
    }
}
