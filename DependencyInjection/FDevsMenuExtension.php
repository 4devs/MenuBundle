<?php

namespace FDevs\MenuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FDevsMenuExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias().'.manager_name', $config['manager_name']);
        $container->setParameter($this->getAlias().'.backend_type_'.$config['db_driver'], true);
        $container->setParameter($this->getAlias().'.menu_class', $config['menu_class']);
        $container->setParameter($this->getAlias().'.default_route_parameters', $config['default_route_parameters']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load($config['db_driver'].'.xml');
        $loader->load('service.xml');
        if ($config['cache_provider']) {
            $container->setAlias('f_devs_menu.cache_provider', $config['cache_provider']);
            $loader->load('cache.xml');
        }
        if ($config['admin_service']) {
            $loader->load(sprintf('admin/%s.xml', $config['admin_service']));
        }
        $loader->load('form.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = ['twig' => ['template' => 'FDevsMenuBundle:Menu:base.html.twig']];
        $container->prependExtensionConfig('knp_menu', $config);
    }
}
