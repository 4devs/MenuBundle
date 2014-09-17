<?php

namespace FDevs\MenuBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FDevs\MenuBundle\Model\Menu;

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
    public function createMenu()
    {
        $class = $this->getClass();

        return new $class();
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
