<?php

namespace FDevs\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use FDevs\Locale\Model\LocaleText;

class MenuNode extends MenuItem
{
    const LINK_AUTO = 1;

    /** @var mixed */
    protected $content;

    /** @var int */
    protected $linkType = self::LINK_AUTO;

    /** @var bool */
    protected $routeAbsolute = false;

    /** @var Route */
    protected $route;

    /** @var ArrayCollection|array|LocaleText[] */
    protected $label;

    /** @var array */
    protected $routeParameters = [];

    /**
     * {@inheritDoc}
     */
    public function __construct($name = '', FactoryInterface $factory = null)
    {
        $this->name = (string)$name;
        $this->factory = $factory;
        $this->label = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * is route absolute
     *
     * @return boolean
     */
    public function isRouteAbsolute()
    {
        return $this->routeAbsolute;
    }

    /**
     * set route absolute
     *
     * @param boolean $routeAbsolute
     *
     * @return self
     */
    public function setRouteAbsolute($routeAbsolute)
    {
        $this->routeAbsolute = $routeAbsolute;

        return $this;
    }

    /**
     * get route parameters
     *
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }

    /**
     * set route parameters
     *
     * @param array $routeParameters
     *
     * @return self
     */
    public function setRouteParameters($routeParameters)
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }

    /**
     * get route
     *
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * set route
     *
     * @param Route $route
     *
     * @return self
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;

        return $this;
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

    /**
     * copy
     *
     * @return MenuNode
     */
    public function copy()
    {
        $newMenu = clone $this;
        $newMenu->setChildren([]);
        $newMenu->setParent(null);
        foreach ($this->getChildren() as $child) {
            $newMenu->addChild($child->copy());
        }

        return $newMenu;
    }
}
