<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim-Psr7/blob/master/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Slim\Psr7\Factory;

use InvalidArgumentException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Prokerala\Astrology\Vendor\Slim\Psr7\Headers;
use Prokerala\Astrology\Vendor\Slim\Psr7\Request;
use function is_string;
class RequestFactory implements \Psr\Http\Message\RequestFactoryInterface
{
    /**
     * @var StreamFactoryInterface|StreamFactory
     */
    protected $streamFactory;
    /**
     * @var UriFactoryInterface|UriFactory
     */
    protected $uriFactory;
    /**
     * @param StreamFactoryInterface|null $streamFactory
     * @param UriFactoryInterface|null    $uriFactory
     */
    public function __construct(?\Psr\Http\Message\StreamFactoryInterface $streamFactory = null, ?\Psr\Http\Message\UriFactoryInterface $uriFactory = null)
    {
        if (!isset($streamFactory)) {
            $streamFactory = new \Prokerala\Astrology\Vendor\Slim\Psr7\Factory\StreamFactory();
        }
        if (!isset($uriFactory)) {
            $uriFactory = new \Prokerala\Astrology\Vendor\Slim\Psr7\Factory\UriFactory();
        }
        $this->streamFactory = $streamFactory;
        $this->uriFactory = $uriFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function createRequest(string $method, $uri) : \Psr\Http\Message\RequestInterface
    {
        if (\is_string($uri)) {
            $uri = $this->uriFactory->createUri($uri);
        }
        if (!$uri instanceof \Psr\Http\Message\UriInterface) {
            throw new \InvalidArgumentException('Parameter 2 of RequestFactory::createRequest() must be a string or a compatible UriInterface.');
        }
        $body = $this->streamFactory->createStream();
        return new \Prokerala\Astrology\Vendor\Slim\Psr7\Request($method, $uri, new \Prokerala\Astrology\Vendor\Slim\Psr7\Headers(), [], [], $body);
    }
}
