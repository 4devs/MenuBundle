<?php

namespace FDevs\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

trait MenuReferrersTrait
{
    /** @var ArrayCollection */
    protected $menuList;

    /**
     * get Menu List
     *
     * @return MenuNode[]
     */
    public function getMenuList()
    {
        return $this->menuList;
    }

    /**
     * set Menu List
     *
     * @param MenuNode[] $menuList
     *
     * @return self
     */
    public function setMenuList(array $menuList)
    {
        $this->menuList = new ArrayCollection();
        foreach ($menuList as $menu) {
            $this->addMenu($menu);
        }

        return $this;
    }

    /**
     * add Menu
     *
     * @param MenuNode $menuNode
     *
     * @return $this
     */
    public function addMenu(MenuNode $menuNode)
    {
        if (!$this->menuList) {
            $this->menuList = new ArrayCollection();
        }
        $this->menuList->add($menuNode);

        return $this;
    }

    /**
     * remove Menu
     *
     * @param MenuNode $menuNode
     *
     * @return bool
     */
    public function removeMenu(MenuNode $menuNode)
    {
        return $this->menuList->removeElement($menuNode);
    }

    /**
     * get Primary Menu
     *
     * @return MenuNode|null
     */
    public function getPrimaryMenu()
    {
        return $this->menuList ? $this->menuList->first() : null;
    }

    /**
     * @param MenuNode $menuNode
     *
     * @return $this
     */
    public function setPrimaryMenu(MenuNode $menuNode)
    {
        $this->menuList = new ArrayCollection();
        $this->menuList->add($menuNode);

        return $this;
    }

}
