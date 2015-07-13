<?php

namespace FDevs\MenuBundle;

final class FDevsMenuEvents
{
    /**
     * The PRE_UPDATE_MENU event is dispatched just before the menu update
     *
     * The event listener method receives a FDevs\MenuBundle\Event\MenuEvent instance
     */
    const PRE_UPDATE_MENU = 'f_devs_menu.pre_update_menu';
    /**
     * The POST_UPDATE_MENU event is dispatched just after update menu
     *
     * The event listener method receives a FDevs\MenuBundle\Event\MenuEvent instance
     */
    const POST_UPDATE_MENU = 'f_devs_menu.post_update_menu';
}
