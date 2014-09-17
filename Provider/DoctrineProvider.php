<?php
namespace FDevs\MenuBundle\Provider;

use Doctrine\Common\Persistence\ObjectManager;

abstract class DoctrineProvider
{
    /** @var ObjectManager */
    protected $objectManager;
    /** @var  string */
    protected $className;

    /**
     * @param ObjectManager $managerRegistry
     * @param string        $className
     */
    public function  __construct(ObjectManager $managerRegistry, $className)
    {
        $this->className = $className;
        $this->objectManager = $managerRegistry;
    }

    /**
     * Get the object manager named $managerName from the registry.
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->className);
    }

}
