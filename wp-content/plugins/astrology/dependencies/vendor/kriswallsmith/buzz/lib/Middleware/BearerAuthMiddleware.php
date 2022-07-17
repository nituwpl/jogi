<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Prokerala\Astrology\Vendor\Buzz\Exception\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class BearerAuthMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    private $accessToken;
    public function __construct(string $accessToken)
    {
        if (empty($accessToken)) {
            throw new \Prokerala\Astrology\Vendor\Buzz\Exception\InvalidArgumentException('You must supply a non empty accessToken');
        }
        $this->accessToken = $accessToken;
    }
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $request = $request->withAddedHeader('Authorization', \sprintf('Bearer %s', $this->accessToken));
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        return $next($request, $response);
    }
}
