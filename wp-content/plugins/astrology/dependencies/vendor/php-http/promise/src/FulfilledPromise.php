<?php

namespace Prokerala\Astrology\Vendor\Http\Promise;

/**
 * A promise already fulfilled.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class FulfilledPromise implements \Prokerala\Astrology\Vendor\Http\Promise\Promise
{
    /**
     * @var mixed
     */
    private $result;
    /**
     * @param $result
     */
    public function __construct($result)
    {
        $this->result = $result;
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
            return new self($onFulfilled($this->result));
        } catch (\Exception $e) {
            return new \Prokerala\Astrology\Vendor\Http\Promise\RejectedPromise($e);
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
            return $this->result;
        }
    }
}
