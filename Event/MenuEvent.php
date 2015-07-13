<?php

namespace FDevs\MenuBundle\Event;

use FDevs\MenuBundle\Model\Menu;
use Symfony\Component\EventDispatcher\Event;

class MenuEvent extends Event
{
    /** @var Menu */
    private $menu;

    /**
     * init.
     *
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * get menu
     *
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
