<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class BasicAuthMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    private $username;
    private $password;
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $request = $request->withAddedHeader('Authorization', \sprintf('Basic %s', \base64_encode($this->username . ':' . $this->password)));
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        return $next($request, $response);
    }
}
