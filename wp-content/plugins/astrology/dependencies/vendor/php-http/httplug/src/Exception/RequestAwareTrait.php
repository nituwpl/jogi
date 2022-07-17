<?php

namespace Prokerala\Astrology\Vendor\Http\Client\Exception;

use Psr\Http\Message\RequestInterface;
trait RequestAwareTrait
{
    /**
     * @var RequestInterface
     */
    private $request;
    private function setRequest(\Psr\Http\Message\RequestInterface $request)
    {
        $this->request = $request;
    }
    /**
     * {@inheritdoc}
     */
    public function getRequest() : \Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
}
