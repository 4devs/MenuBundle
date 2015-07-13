<?php

namespace FDevs\MenuBundle\EventListener;

use FDevs\MenuBundle\Event\MenuEvent;
use FDevs\MenuBundle\Provider\CacheMenuProvider;

class CacheListener
{
    /** @var CacheMenuProvider */
    private $cache;

    /**
     * init.
     *
     * @param CacheMenuProvider $cache
     */
    public function __construct(CacheMenuProvider $cache)
    {
        $this->cache = $cache;
    }

    /**
     * update menu
     *
     * @param MenuEvent $event
     */
    public function updateMenu(MenuEvent $event)
    {
        $menu = $event->getMenu()->getMenuName();
        $this->cache->updateMenu($menu);
    }
}
