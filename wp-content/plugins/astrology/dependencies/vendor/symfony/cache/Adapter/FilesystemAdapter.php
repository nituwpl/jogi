<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prokerala\Astrology\Vendor\Symfony\Component\Cache\Adapter;

use Prokerala\Astrology\Vendor\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use Prokerala\Astrology\Vendor\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use Prokerala\Astrology\Vendor\Symfony\Component\Cache\PruneableInterface;
use Prokerala\Astrology\Vendor\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \Prokerala\Astrology\Vendor\Symfony\Component\Cache\Adapter\AbstractAdapter implements \Prokerala\Astrology\Vendor\Symfony\Component\Cache\PruneableInterface
{
    use FilesystemTrait;
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null, \Prokerala\Astrology\Vendor\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->marshaller = $marshaller ?? new \Prokerala\Astrology\Vendor\Symfony\Component\Cache\Marshaller\DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
