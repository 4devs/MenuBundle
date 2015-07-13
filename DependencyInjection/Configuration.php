<?php

namespace FDevs\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('f_devs_menu');
        $supportedDrivers = ['mongodb'];

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                    ->ifNotInArray($supportedDrivers)
                    ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->defaultValue('mongodb')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('menu_class')->defaultValue('FDevs\MenuBundle\Model\Menu')->cannotBeEmpty()->end()
                ->scalarNode('cache_provider')->defaultNull()->end()
                ->scalarNode('manager_name')->defaultNull()->end()
                ->arrayNode('default_route_parameters')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end();
        $this->addAdminServiceNode($rootNode);

        return $treeBuilder;
    }

    /**
     * add Admin Service Node
     *
     * @param ArrayNodeDefinition $node
     *
     * @return mixed
     */
    private function addAdminServiceNode(ArrayNodeDefinition $node)
    {
        $supportedAdminService = ['sonata'];

        return $node
            ->children()
                ->scalarNode('admin_service')
                ->defaultNull()
                    ->validate()
                    ->ifNotInArray($supportedAdminService)
                    ->thenInvalid('The admin service %s is not supported. Please choose one of '.json_encode($supportedAdminService))
                    ->end()
                ->end()
            ->end();
    }
}
