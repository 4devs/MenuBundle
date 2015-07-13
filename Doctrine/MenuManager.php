<?php

namespace FDevs\MenuBundle\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use FDevs\MenuBundle\Model\Menu;
use FDevs\MenuBundle\Model\MenuNode;
use Knp\Menu\Factory\ExtensionInterface;

class MenuManager implements FactoryInterface
{
    /** @var ObjectManager */
    private $manager;

    /** @var string */
    private $class;

    /** @var array */
    private $extensions = [];

    /** @var array|ExtensionInterface[] */
    private $sorted = [];

    /**
     * init.
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
     * {@inheritDoc}
     */
    public function createItem($name, array $options = [])
    {
        foreach ($this->getExtensions() as $extension) {
            $options = $extension->buildOptions($options);
        }

        $class = $this->getClass();
        /** @var Menu $item */
        $item = new $class($name, $this);
        $item->setMenuName($name);
        $this->buildItem($item, $options);

        return $item;
    }

    /**
     * Adds a factory extension
     *
     * @param ExtensionInterface $extension
     * @param integer            $priority
     */
    public function addExtension(ExtensionInterface $extension, $priority = 0)
    {
        $this->extensions[$priority][] = $extension;
        $this->sorted = [];
    }

    /**
     * get Extensions
     *
     * @return ArrayCollection|ExtensionInterface[]
     */
    private function getExtensions()
    {
        if (count($this->extensions) && !count($this->sorted)) {
            krsort($this->extensions);
            $this->sorted = call_user_func_array('array_merge', $this->extensions);
        }

        return $this->sorted;
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
     * @param MenuNode $item
     * @param string   $name
     *
     * @return Menu
     */
    public function createChild(MenuNode $item, $name)
    {
        $item->setFactory($this);
        $menu = $this->createItem($name);
        $menu->setName($item->getName());
        $item->addChild($menu);

        return $menu;
    }

    /**
     * {@inheritDoc}
     */
    public function findMenuByName($name)
    {
        $menuName = explode(':', $name);
        $name = isset($menuName[1]) ? $menuName[1] : $menuName[0];
        $menu = $this->getRepository()->findOneBy(['menuName' => $menuName[0], 'name' => $name]);
        $menu->setFactory($this);

        return $menu;
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

    /**
     * get repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        return $this->manager->getRepository($this->getClass());
    }

    /**
     * build Item
     *
     * @param MenuNode $menu
     * @param array    $options
     */
    private function buildItem(MenuNode $menu, array $options = [])
    {
        foreach ($this->getExtensions() as $extension) {
            $extension->buildItem($menu, $options);
        }
    }
}
