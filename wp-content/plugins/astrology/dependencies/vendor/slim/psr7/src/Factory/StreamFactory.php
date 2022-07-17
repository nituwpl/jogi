<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim-Psr7/blob/master/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Prokerala\Astrology\Vendor\Slim\Psr7\Factory;

use InvalidArgumentException;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Prokerala\Astrology\Vendor\Slim\Psr7\Stream;
use ValueError;
use function fopen;
use function fwrite;
use function is_resource;
use function restore_error_handler;
use function rewind;
use function set_error_handler;
class StreamFactory implements \Psr\Http\Message\StreamFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws RuntimeException
     */
    public function createStream(string $content = '') : \Psr\Http\Message\StreamInterface
    {
        $resource = \fopen('php://temp', 'rw+');
        if (!\is_resource($resource)) {
            throw new \RuntimeException('StreamFactory::createStream() could not open temporary file stream.');
        }
        \fwrite($resource, $content);
        \rewind($resource);
        return $this->createStreamFromResource($resource);
    }
    /**
     * {@inheritdoc}
     */
    public function createStreamFromFile(string $filename, string $mode = 'r', \Psr\Http\Message\StreamInterface $cache = null) : \Psr\Http\Message\StreamInterface
    {
        \set_error_handler(static function (int $errno, string $errstr) use($filename, $mode) : void {
            throw new \RuntimeException("Unable to open {$filename} using mode {$mode}: {$errstr}", $errno);
        });
        try {
            $resource = \fopen($filename, $mode);
        } catch (\ValueError $exception) {
            throw new \RuntimeException("Unable to open {$filename} using mode {$mode}: " . $exception->getMessage());
        } finally {
            \restore_error_handler();
        }
        if (!\is_resource($resource)) {
            throw new \RuntimeException("StreamFactory::createStreamFromFile() could not create resource from file `{$filename}`");
        }
        return new \Prokerala\Astrology\Vendor\Slim\Psr7\Stream($resource, $cache);
    }
    /**
     * {@inheritdoc}
     */
    public function createStreamFromResource($resource, \Psr\Http\Message\StreamInterface $cache = null) : \Psr\Http\Message\StreamInterface
    {
        if (!\is_resource($resource)) {
            throw new \InvalidArgumentException('Parameter 1 of StreamFactory::createStreamFromResource() must be a resource.');
        }
        return new \Prokerala\Astrology\Vendor\Slim\Psr7\Stream($resource, $cache);
    }
}
