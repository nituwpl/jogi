<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Prokerala\Astrology\Vendor\Buzz\Middleware\Cookie\Cookie;
use Prokerala\Astrology\Vendor\Buzz\Middleware\Cookie\CookieJar;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class CookieMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    private $cookieJar;
    public function __construct()
    {
        $this->cookieJar = new \Prokerala\Astrology\Vendor\Buzz\Middleware\Cookie\CookieJar();
    }
    public function setCookies(array $cookies) : void
    {
        $this->cookieJar->setCookies($cookies);
    }
    /**
     * @return Cookie[]
     */
    public function getCookies() : array
    {
        return $this->cookieJar->getCookies();
    }
    /**
     * Adds a cookie to the current cookie jar.
     *
     * @param Cookie $cookie A cookie object
     */
    public function addCookie(\Prokerala\Astrology\Vendor\Buzz\Middleware\Cookie\Cookie $cookie) : void
    {
        $this->cookieJar->addCookie($cookie);
    }
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $this->cookieJar->clearExpiredCookies();
        $request = $this->cookieJar->addCookieHeaders($request);
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        $this->cookieJar->processSetCookieHeaders($request, $response);
        return $next($request, $response);
    }
}
