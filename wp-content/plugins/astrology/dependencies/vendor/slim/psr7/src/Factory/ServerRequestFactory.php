<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim-Psr7/blob/master/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Slim\Psr7\Factory;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Prokerala\Astrology\Vendor\Slim\Psr7\Cookies;
use Prokerala\Astrology\Vendor\Slim\Psr7\Headers;
use Prokerala\Astrology\Vendor\Slim\Psr7\Request;
use Prokerala\Astrology\Vendor\Slim\Psr7\Stream;
use Prokerala\Astrology\Vendor\Slim\Psr7\UploadedFile;
use function current;
use function explode;
use function fopen;
use function in_array;
use function is_string;
class ServerRequestFactory implements \Psr\Http\Message\ServerRequestFactoryInterface
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
    public function createServerRequest(string $method, $uri, array $serverParams = []) : \Psr\Http\Message\ServerRequestInterface
    {
        if (\is_string($uri)) {
            $uri = $this->uriFactory->createUri($uri);
        }
        if (!$uri instanceof \Psr\Http\Message\UriInterface) {
            throw new \InvalidArgumentException('URI must either be string or instance of ' . \Psr\Http\Message\UriInterface::class);
        }
        $body = $this->streamFactory->createStream();
        $headers = new \Prokerala\Astrology\Vendor\Slim\Psr7\Headers();
        $cookies = [];
        if (!empty($serverParams)) {
            $headers = \Prokerala\Astrology\Vendor\Slim\Psr7\Headers::createFromGlobals();
            $cookies = \Prokerala\Astrology\Vendor\Slim\Psr7\Cookies::parseHeader($headers->getHeader('Cookie', []));
        }
        return new \Prokerala\Astrology\Vendor\Slim\Psr7\Request($method, $uri, $headers, $cookies, $serverParams, $body);
    }
    /**
     * Create new ServerRequest from environment.
     *
     * @internal This method is not part of PSR-17
     *
     * @return Request
     */
    public static function createFromGlobals() : \Prokerala\Astrology\Vendor\Slim\Psr7\Request
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $uri = (new \Prokerala\Astrology\Vendor\Slim\Psr7\Factory\UriFactory())->createFromGlobals($_SERVER);
        $headers = \Prokerala\Astrology\Vendor\Slim\Psr7\Headers::createFromGlobals();
        $cookies = \Prokerala\Astrology\Vendor\Slim\Psr7\Cookies::parseHeader($headers->getHeader('Cookie', []));
        // Cache the php://input stream as it cannot be re-read
        $cacheResource = \fopen('php://temp', 'wb+');
        $cache = $cacheResource ? new \Prokerala\Astrology\Vendor\Slim\Psr7\Stream($cacheResource) : null;
        $body = (new \Prokerala\Astrology\Vendor\Slim\Psr7\Factory\StreamFactory())->createStreamFromFile('php://input', 'r', $cache);
        $uploadedFiles = \Prokerala\Astrology\Vendor\Slim\Psr7\UploadedFile::createFromGlobals($_SERVER);
        $request = new \Prokerala\Astrology\Vendor\Slim\Psr7\Request($method, $uri, $headers, $cookies, $_SERVER, $body, $uploadedFiles);
        $contentTypes = $request->getHeader('Content-Type') ?? [];
        $parsedContentType = '';
        foreach ($contentTypes as $contentType) {
            $fragments = \explode(';', $contentType);
            $parsedContentType = \current($fragments);
        }
        $contentTypesWithParsedBodies = ['application/x-www-form-urlencoded', 'multipart/form-data'];
        if ($method === 'POST' && \in_array($parsedContentType, $contentTypesWithParsedBodies)) {
            return $request->withParsedBody($_POST);
        }
        return $request;
    }
}
