<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prokerala\Astrology\Vendor\Symfony\Component\Cache;

use Prokerala\Astrology\Vendor\Doctrine\Common\Cache\CacheProvider;
use Psr\Cache\CacheItemPoolInterface;
use Prokerala\Astrology\Vendor\Symfony\Contracts\Service\ResetInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DoctrineProvider extends \Prokerala\Astrology\Vendor\Doctrine\Common\Cache\CacheProvider implements \Prokerala\Astrology\Vendor\Symfony\Component\Cache\PruneableInterface, \Prokerala\Astrology\Vendor\Symfony\Component\Cache\ResettableInterface
{
    private $pool;
    public function __construct(\Psr\Cache\CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }
    /**
     * {@inheritdoc}
     */
    public function prune()
    {
        return $this->pool instanceof \Prokerala\Astrology\Vendor\Symfony\Component\Cache\PruneableInterface && $this->pool->prune();
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        if ($this->pool instanceof \Prokerala\Astrology\Vendor\Symfony\Contracts\Service\ResetInterface) {
            $this->pool->reset();
        }
        $this->setNamespace($this->getNamespace());
    }
    /**
     * {@inheritdoc}
     *
     * @return mixed
     */
    protected function doFetch($id)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        return $item->isHit() ? $item->get() : \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doContains($id)
    {
        return $this->pool->hasItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $item = $this->pool->getItem(\rawurlencode($id));
        if (0 < $lifeTime) {
            $item->expiresAfter($lifeTime);
        }
        return $this->pool->save($item->set($data));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doDelete($id)
    {
        return $this->pool->deleteItem(\rawurlencode($id));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    protected function doFlush()
    {
        return $this->pool->clear();
    }
    /**
     * {@inheritdoc}
     *
     * @return array|null
     */
    protected function doGetStats()
    {
        return null;
    }
}
