<?php

namespace FDevs\MenuBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FDevs\MenuBundle\Model\Menu;
use FDevs\MenuBundle\Model\MenuNode;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;

class MenuManager
{
    /** @var ObjectManager */
    private $manager;

    /** @var string */
    private $class;

    /**
     * init
     *
     * @param ObjectManager $manager
     * @param string        $class
     */
    public function __construct(ObjectManager $manager, $class)
    {
        $this->class = $class;
        $this->manager = $manager;
    }

    /**
     * persist
     *
     * @param Menu $menu
     *
     * @return $this
     */
    public function persist(Menu $menu)
    {
        $this->manager->persist($menu);

        return $this;
    }

    /**
     * get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * create Menu
     *
     * @return Menu
     */
    public function createMenu($name)
    {
        $class = $this->getClass();
        /** @var Menu $menu */
        $menu = new $class();
        $menu->setMenuName($name);
        $menu->setName($name);

        return $menu;
    }

    /**
     * @param MenuNode $item
     * @param string   $name
     *
     * @return Menu
     */
    public function createChild(MenuNode $item, $name)
    {
        $menu = $this->createMenu($name);
        $menu->setName($item->getName());
        $item->addChild($menu);

        return $menu;
    }

    /**
     * find Menu By Name
     *
     * @param string $name
     *
     * @return Menu
     */
    public function findMenuByName($name)
    {
        return $this->manager->getRepository($this->getClass())->findOneBy(['name' => $name]);
    }

    /**
     * remove
     *
     * @param Menu $menu
     *
     * @return $this
     */
    public function remove(Menu $menu)
    {
        $this->manager->remove($menu);

        return $this;
    }

    /**
     * flush
     *
     * @return $this
     */
    public function flush()
    {
        $this->manager->flush();

        return $this;
    }
}
