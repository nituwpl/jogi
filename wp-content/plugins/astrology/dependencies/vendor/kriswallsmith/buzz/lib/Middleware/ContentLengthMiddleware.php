<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class ContentLengthMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $body = $request->getBody();
        if (!$request->hasHeader('Content-Length')) {
            $request = $request->withAddedHeader('Content-Length', (string) $body->getSize());
        }
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        return $next($request, $response);
    }
}
