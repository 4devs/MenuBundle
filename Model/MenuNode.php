<?php

namespace FDevs\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;

class MenuNode extends MenuItem
{
    /** @var mixed */
    protected $id;

    /** @var string */
    protected $menuName;

    /** @var mixed */
    protected $content;

    /** @var string */
    protected $linkType;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = '', FactoryInterface $factory = null)
    {
        $this->name = (string)$name;
        $this->factory = $factory;
        $this->children = new ArrayCollection();
    }

    /**
     * get menu
     *
     * @return string
     */
    public function getMenuName()
    {
        return $this->menuName;
    }

    /**
     * set menu
     *
     * @param string $menu
     *
     * @return self
     */
    public function setMenuName($menu)
    {
        $this->menuName = $menu;

        return $this;
    }

    /**
     * get Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param string $linkType
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        if ($this->name == $name) {
            return $this;
        }

        $parent = $this->getParent();
        if (null !== $parent && isset($parent[$name])) {
            throw new \InvalidArgumentException('Cannot rename item, name is already used by sibling.');
        }

        $oldName = $this->name;
        $this->name = $name;
        if (null !== $parent) {

            /** @var $child \Doctrine\ODM\MongoDB\PersistentCollection */
            $child = $parent->getChildren();
            $offset = $child->indexOf($this);
            $child->set($offset, $this);

            $parent->setChildren($child->getValues());
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function actsLikeLast()
    {
        // root items are never "marked" as last
        if ($this->isRoot()) {
            return false;
        }

        // A menu acts like last only if it is displayed
        if (!$this->isDisplayed()) {
            return false;
        }

        // if we're last and visible, we're last, period.
        if ($this->isLast()) {
            return true;
        }

        $children = $this->getParent()->getChildren();
        foreach ($children as $child) {
            // loop until we find a visible menu. If its this menu, we're first
            if ($child->isDisplayed()) {
                return $child->getName() === $this->getName();
            }
        }

        return false;
    }


}
