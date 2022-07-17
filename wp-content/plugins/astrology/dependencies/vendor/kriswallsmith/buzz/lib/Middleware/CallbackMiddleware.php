<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Prokerala\Astrology\Vendor\Buzz\Exception\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CallbackMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    private $callable;
    /**
     * The callback should expect either one or two arguments, depending on
     * whether it is receiving a pre or post send notification.
     *
     *     $middleware = new CallbackMiddleware(function($request, $response = null) {
     *         if ($response) {
     *             // postSend
     *         } else {
     *             // preSend
     *         }
     *     });
     *
     * @param mixed $callable A PHP callable
     *
     * @throws InvalidArgumentException If the argument is not callable
     */
    public function __construct($callable)
    {
        if (!\is_callable($callable)) {
            throw new \Prokerala\Astrology\Vendor\Buzz\Exception\InvalidArgumentException('The argument is not callable.');
        }
        $this->callable = $callable;
    }
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $request = \call_user_func($this->callable, $request);
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        $response = \call_user_func($this->callable, $request, $response);
        return $next($request, $response);
    }
}
