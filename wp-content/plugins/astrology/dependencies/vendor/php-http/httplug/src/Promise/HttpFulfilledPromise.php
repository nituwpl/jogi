<?php

namespace Prokerala\Astrology\Vendor\Http\Client\Promise;

use Prokerala\Astrology\Vendor\Http\Client\Exception;
use Prokerala\Astrology\Vendor\Http\Promise\Promise;
use Psr\Http\Message\ResponseInterface;
final class HttpFulfilledPromise implements \Prokerala\Astrology\Vendor\Http\Promise\Promise
{
    /**
     * @var ResponseInterface
     */
    private $response;
    public function __construct(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->response = $response;
    }
    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        if (null === $onFulfilled) {
            return $this;
        }
        try {
            return new self($onFulfilled($this->response));
        } catch (\Prokerala\Astrology\Vendor\Http\Client\Exception $e) {
            return new \Prokerala\Astrology\Vendor\Http\Client\Promise\HttpRejectedPromise($e);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return \Prokerala\Astrology\Vendor\Http\Promise\Promise::FULFILLED;
    }
    /**
     * {@inheritdoc}
     */
    public function wait($unwrap = \true)
    {
        if ($unwrap) {
            return $this->response;
        }
    }
}
