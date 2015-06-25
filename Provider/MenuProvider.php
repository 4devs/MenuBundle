<?php

namespace FDevs\MenuBundle\Provider;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use FDevs\MenuBundle\Model\MenuNode;
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

    private $menu;

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

        $menuName = explode(':', $name);
        $menu = null;
        $name = isset($menuName[1]) ? $menuName[1] : $menuName[0];
        if (!isset($this->menu[$menuName[0]])) {
            $menuList = $this->getRepository()->findBy(['menuName' => $menuName[0]]);
            $this->menu[$menuName[0]] = $menuList;
        } else {
            $menuList = $this->menu[$menuName[0]];
        }
        if (count($menuList)) {
            $currentList = array_filter($menuList, function (MenuNode $menu) use ($name) {
                return $name === $menu->getName();
            });
            if (count($currentList)) {
                $menu = current($currentList);
            }
        }

        return $menu;
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
