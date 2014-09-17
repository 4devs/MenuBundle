<?php

namespace FDevs\MenuBundle\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuProvider extends DoctrineProvider implements MenuProviderInterface
{
    /** @var FactoryInterface */
    protected $factory;
    /** @var ManagerRegistry */
    protected $objectManager;
    /** @var  Request */
    protected $request;

    /**
     * set Menu Factory
     *
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name, array $options = array())
    {
        $menu = $this->find($name);

        $menuItem = $this->factory->createFromNode($menu);
        if (empty($menuItem)) {
            throw new \InvalidArgumentException(
                "Menu at '$name' is misconfigured (f.e. the route might be incorrect) and could therefore not be instanciated"
            );
        }

        $menuItem->setCurrentUri($this->request->getRequestUri());

        return $menuItem;
    }

    /**
     * {@inheritDoc}
     */
    public function has($name, array $options = array())
    {
        return $this->find($name) != null;
    }

    /**
     * @param $name
     *
     * @return MenuNode
     */
    protected function find($name)
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
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
