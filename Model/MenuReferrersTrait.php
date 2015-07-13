<?php

namespace FDevs\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

trait MenuReferrersTrait
{
    /** @var ArrayCollection|Menu[] */
    protected $menuList;

    /**
     * get Menu List
     *
     * @return Menu[]
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
        $menuNode->setContent($this);
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
     * @param string $menuName
     *
     * @return MenuNode|null
     */
    public function getPrimaryMenu($menuName = '')
    {
        $primaryMenu = null;
        if ($menuName) {
            $menuList = $this->menuList->filter(function (Menu $menu) use ($menuName) {
                return $menu->getMenuName() === $menuName;
            });
            if (count($menuList)) {
                $primaryMenu = $menuList->first();
            }
        } elseif ($this->menuList) {
            $primaryMenu = $this->menuList->first();
        }

        return $primaryMenu;
    }

    /**
     * has menu
     *
     * @param string $menuName
     *
     * @return bool
     */
    public function hasMenu($menuName)
    {
        return $this->menuList->exists(function ($key, Menu $menu) use ($menuName) {
            return $menu->getMenuName() === $menuName;
        });
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
