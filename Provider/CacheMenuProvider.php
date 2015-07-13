<?php

namespace FDevs\MenuBundle\Provider;

use Doctrine\Common\Cache\CacheProvider;
use Knp\Menu\Provider\MenuProviderInterface;

class CacheMenuProvider implements MenuProviderInterface
{
    /** @var MenuProviderInterface */
    private $menuProvider;

    /** @var CacheProvider */
    private $cache;

    /**
     * @param MenuProviderInterface $menuProvider
     * @param CacheProvider         $cache
     */
    public function __construct(MenuProviderInterface $menuProvider, CacheProvider $cache)
    {
        $this->menuProvider = $menuProvider;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name, array $options = [])
    {
        if (!$this->cache->contains($name)) {
            $this->updateMenu($name, $options);
        }

        return unserialize($this->cache->fetch($name));
    }

    /**
     * {@inheritDoc}
     */
    public function has($name, array $options = [])
    {
        return $this->cache->contains($name) ?: $this->menuProvider->has($name, $options);
    }

    /**
     * update menu
     *
     * @param string $name
     * @param array  $options
     *
     * @return $this
     */
    public function updateMenu($name, array $options = [])
    {
        $dbMenu = $this->menuProvider->get($name);
        $this->cache->save($name, serialize($dbMenu->copy()));

        return $this;
    }
}
