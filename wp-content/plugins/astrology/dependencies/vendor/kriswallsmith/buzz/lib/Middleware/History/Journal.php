<?php

declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Buzz\Middleware\History;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class Journal implements \Countable, \IteratorAggregate
{
    /** @var Entry[] */
    private $entries = [];
    private $limit = 10;
    public function __construct(int $limit = 10)
    {
        $this->limit = $limit;
    }
    /**
     * Records an entry in the journal.
     *
     * @param RequestInterface  $request  The request
     * @param ResponseInterface $response The response
     * @param float|null        $duration The duration in seconds
     */
    public function record(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, float $duration = null) : void
    {
        $this->addEntry(new \Prokerala\Astrology\Vendor\Buzz\Middleware\History\Entry($request, $response, $duration));
    }
    public function addEntry(\Prokerala\Astrology\Vendor\Buzz\Middleware\History\Entry $entry) : void
    {
        \array_push($this->entries, $entry);
        $this->entries = \array_slice($this->entries, $this->getLimit() * -1);
        \end($this->entries);
    }
    /**
     * @return Entry[]
     */
    public function getEntries() : array
    {
        return $this->entries;
    }
    public function getLast() : ?\Prokerala\Astrology\Vendor\Buzz\Middleware\History\Entry
    {
        $entry = \end($this->entries);
        return \false === $entry ? null : $entry;
    }
    public function getLastRequest() : ?\Psr\Http\Message\RequestInterface
    {
        $entry = $this->getLast();
        if (null === $entry) {
            return null;
        }
        return $entry->getRequest();
    }
    public function getLastResponse() : ?\Psr\Http\Message\ResponseInterface
    {
        $entry = $this->getLast();
        if (null === $entry) {
            return null;
        }
        return $entry->getResponse();
    }
    public function clear() : void
    {
        $this->entries = [];
    }
    public function count() : int
    {
        return \count($this->entries);
    }
    public function setLimit(int $limit) : void
    {
        $this->limit = $limit;
    }
    public function getLimit() : int
    {
        return $this->limit;
    }
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator(\array_reverse($this->entries));
    }
}
