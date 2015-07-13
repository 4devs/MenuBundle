<?php
namespace FDevs\MenuBundle\Doctrine;

use Knp\Menu\FactoryInterface as BaseFactory;
use FDevs\MenuBundle\Model\Menu;

interface FactoryInterface extends BaseFactory
{
    /**
     * find Menu By Name
     *
     * @param string $name
     *
     * @return Menu
     */
    public function findMenuByName($name);
}
