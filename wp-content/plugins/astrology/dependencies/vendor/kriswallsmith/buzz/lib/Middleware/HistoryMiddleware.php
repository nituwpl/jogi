<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware;

use Prokerala\Astrology\Vendor\Buzz\Middleware\History\Journal;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class HistoryMiddleware implements \Prokerala\Astrology\Vendor\Buzz\Middleware\MiddlewareInterface
{
    private $journal;
    private $startTime;
    public function __construct(\Prokerala\Astrology\Vendor\Buzz\Middleware\History\Journal $journal)
    {
        $this->journal = $journal;
    }
    public function getJournal() : \Prokerala\Astrology\Vendor\Buzz\Middleware\History\Journal
    {
        return $this->journal;
    }
    public function handleRequest(\Psr\Http\Message\RequestInterface $request, callable $next)
    {
        $this->startTime = \microtime(\true);
        return $next($request);
    }
    public function handleResponse(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next)
    {
        $this->journal->record($request, $response, \microtime(\true) - $this->startTime);
        return $next($request, $response);
    }
}
