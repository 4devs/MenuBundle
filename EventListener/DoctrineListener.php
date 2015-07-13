<?php

namespace FDevs\MenuBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use FDevs\MenuBundle\Event\MenuEvent;
use FDevs\MenuBundle\FDevsMenuEvents;
use FDevs\MenuBundle\Model\Menu;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DoctrineListener
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /**
     * init.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * pre update
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if ($object instanceof Menu) {
            $this->eventDispatcher->dispatch(FDevsMenuEvents::PRE_UPDATE_MENU, new MenuEvent($object));
        }
    }

    /**
     * post flush
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if ($object instanceof Menu) {
            $this->eventDispatcher->dispatch(FDevsMenuEvents::POST_UPDATE_MENU, new MenuEvent($object));
        }
    }
}
