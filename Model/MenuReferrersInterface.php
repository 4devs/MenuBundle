<?php

namespace FDevs\MenuBundle\Model;

interface MenuReferrersInterface
{
    /**
     * set Menu List
     *
     * @param MenuNode[] $menuList
     *
     * @return self
     */
    public function setMenuList(array $menuList);

    /**
     * get Menu List
     *
     * @return MenuNode[]
     */
    public function getMenuList();

    /**
     * get Primary Menu
     *
     * @return MenuNode|null
     */
    public function getPrimaryMenu();

    /**
     * @param MenuNode $menuNode
     *
     * @return $this
     */
    public function setPrimaryMenu(MenuNode $menuNode);

    /**
     * @return \FDevs\RoutingBundle\Doctrine\Mongodb\Route
     */
    public function getRoute();
}
