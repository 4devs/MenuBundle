<?php

namespace FDevs\MenuBundle\Sonata\Extension;

use Doctrine\Common\Collections\Collection;
use FDevs\MenuBundle\Model\Menu;
use FDevs\MenuBundle\Model\MenuReferrersInterface;
use FDevs\MenuBundle\Service\MenuManager;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

class PrimaryMenuExtension extends AdminExtension
{
    /** @var MenuManager */
    private $menuManager;

    private $defaultRouteParameters = [];

    /**
     * {@inheritDoc}
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_menu', ['translation_domain' => 'FDevsMenuBundle'])
            ->add(
                'menuList',
                'collection',
                [
                    'type' => 'fdevs_menu_node',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false,
                    'options' => ['label' => false]
                ]
            )
            ->end();
    }

    /**
     * {@inheritDoc}
     */
    public function alterNewInstance(AdminInterface $admin, $object)
    {
        /** @var \FDevs\MenuBundle\Model\Menu $menu */
        $menu = $this->menuManager->createMenu();
        $this->setContent($menu, $object);
        /** @var MenuReferrersInterface $object */
        $object->setPrimaryMenu($menu);
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate(AdminInterface $admin, $object)
    {
        $this->updateMenu($object);
    }

    /**
     * update Menu
     *
     * @param MenuReferrersInterface $object
     *
     * @return $this
     */
    public function updateMenu(MenuReferrersInterface $object)
    {

        /** @var \FDevs\MenuBundle\Model\MenuReferrersInterface $object */
        $menuList = $object->getMenuList();
        foreach ($menuList as $menu) {
            if (!$menu->getId()) {
                $this->setContent($menu, $object);
                $this->menuManager->persist($menu);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function preRemove(AdminInterface $admin, $object)
    {
        /** @var \FDevs\MenuBundle\Model\MenuReferrersInterface $object */
        $menuList = $object->getMenuList();
        foreach ($menuList as $menu) {
            if ($menu->getId()) {
                $this->menuManager->remove($menu);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist(AdminInterface $admin, $object)
    {
        $this->updateMenu($object);
    }

    /**
     * set Menu Manager
     *
     * @param MenuManager $manager
     *
     * @return $this
     */
    public function setMenuManager(MenuManager $manager)
    {
        $this->menuManager = $manager;

        return $this;
    }

    /**
     * @param array $defaultRouteParameters
     *
     * @return $this
     */
    public function setDefaultRouteParameters($defaultRouteParameters)
    {
        $this->defaultRouteParameters = $defaultRouteParameters;

        return $this;
    }

    private function setContent(Menu $menu, $content)
    {
        $menu->setContent($content);
        if ($content instanceof RouteReferrersReadInterface && $routes = $content->getRoutes()) {
            $route = '';
            if ($routes instanceof Collection) {
                $route = $routes->first();
            } elseif (is_array($routes)) {
                $route = current($routes);
            }
            if ($route instanceof \FDevs\RoutingBundle\Doctrine\Mongodb\Route) {
                $menu->setRoute($route->getName());
                $menu->setRouteParameters(array_merge($route->getDefaults(), $this->defaultRouteParameters));
            }
        }
    }
}
