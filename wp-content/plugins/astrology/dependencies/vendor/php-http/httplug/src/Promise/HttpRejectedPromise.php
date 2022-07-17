<?php

namespace Prokerala\Astrology\Vendor\Http\Client\Promise;

use Prokerala\Astrology\Vendor\Http\Client\Exception;
use Prokerala\Astrology\Vendor\Http\Promise\Promise;
final class HttpRejectedPromise implements \Prokerala\Astrology\Vendor\Http\Promise\Promise
{
    /**
     * @var Exception
     */
    private $exception;
    public function __construct(\Prokerala\Astrology\Vendor\Http\Client\Exception $exception)
    {
        $this->exception = $exception;
    }
    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        if (null === $onRejected) {
            return $this;
        }
        try {
            return new \Prokerala\Astrology\Vendor\Http\Client\Promise\HttpFulfilledPromise($onRejected($this->exception));
        } catch (\Prokerala\Astrology\Vendor\Http\Client\Exception $e) {
            return new self($e);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return \Prokerala\Astrology\Vendor\Http\Promise\Promise::REJECTED;
    }
    /**
     * {@inheritdoc}
     */
    public function wait($unwrap = \true)
    {
        if ($unwrap) {
            throw $this->exception;
        }
    }
}
