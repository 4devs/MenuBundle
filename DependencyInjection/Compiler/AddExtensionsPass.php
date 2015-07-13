<?php

namespace FDevs\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AddExtensionsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('f_devs_menu.menu_manager')) {
            return;
        }

        $definition = $container->getDefinition('f_devs_menu.menu_manager');
        foreach ($container->findTaggedServiceIds('f_devs_menu.menu_extension') as $id => $tags) {
            foreach ($tags as $tag) {
                $priority = isset($tag['priority']) ? $tag['priority'] : 0;
                $definition->addMethodCall('addExtension', array(new Reference($id), $priority));
            }
        }
    }
}
