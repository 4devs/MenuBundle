<?php

namespace FDevs\MenuBundle\Provider;

use FDevs\MenuBundle\Model\Menu;
use FDevs\MenuBundle\Doctrine\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuProvider implements MenuProviderInterface
{
    /** @var FactoryInterface */
    protected $factory;

    /** @var  Request */
    protected $request;

    /**
     * init.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name, array $options = [])
    {
        $menuItem = $this->find($name);
        if (empty($menuItem)) {
            throw new \InvalidArgumentException(
                "Menu at '$name' is misconfigured (f.e. the route might be incorrect) and could therefore not be instanciated"
            );
        }

        return $menuItem;
    }

    /**
     * {@inheritDoc}
     */
    public function has($name, array $options = [])
    {
        return $this->find($name) != null;
    }

    /**
     * @param $name
     *
     * @return Menu
     */
    protected function find($name)
    {
        return $this->factory->findMenuByName($name);
    }

    /**
     * Set the request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }
}
