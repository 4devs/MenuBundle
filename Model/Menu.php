<?php

namespace FDevs\MenuBundle\Model;

use Knp\Menu\ItemInterface;

class Menu extends MenuNode implements \Serializable
{
    /** @var mixed */
    protected $id;

    /** @var string */
    protected $menuName;

    /** @var int */
    protected $position = 0;

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
     * get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * set position
     *
     * @param int $position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addChild($child, array $options = [])
    {
        if (!$child instanceof ItemInterface) {
            $child = $this->factory->createItem($child, $options);
            $child->setMenuName($this->getMenuName());
        } elseif (null !== $child->getParent()) {
            throw new \InvalidArgumentException('Cannot add menu item as child, it already belongs to another menu (e.g. has a parent).');
        }

        $child->setParent($this);

        $this->children[$child->getName()] = $child;

        return $child;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize([
            'id'               => $this->id,
            'attributes'       => $this->attributes,
            'position'         => $this->position,
            'name'             => $this->name,
            'menu_name'        => $this->menuName,
            'label'            => $this->label->toArray(),
            'uri'              => $this->uri,
            'route'            => $this->route,
            'display'          => $this->display,
            'route_absolute'   => $this->routeAbsolute,
            'children'         => $this->children,
            'route_parameters' => $this->routeParameters,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->id = $data['id'];
        $this->attributes = $data['attributes'];
        $this->position = $data['position'];
        $this->name = $data['name'];
        $this->menuName = $data['menu_name'];
        $this->label = $data['label'];
        $this->uri = $data['uri'];
        $this->route = $data['route'];
        $this->display = $data['display'];
        $this->routeAbsolute = $data['route_absolute'];
        $this->children = $data['children'];
        $this->routeParameters = $data['route_parameters'];
    }
}
