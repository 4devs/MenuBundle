<?php

namespace FDevs\MenuBundle\Sonata\Extension;

use FDevs\MenuBundle\Model\MenuReferrersInterface;
use FDevs\MenuBundle\Service\MenuManager;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;

class PrimaryMenuExtension extends AdminExtension
{
    /** @var MenuManager */
    private $menuManager;

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
        $menu->setContent($object);
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
                $menu->setContent($object);
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
}
